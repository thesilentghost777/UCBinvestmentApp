<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * Affiche la liste d'amis de l'utilisateur.
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer les amis acceptés
        $acceptedFriends = $user->friends()
            ->where('status', 'accepted')
            ->with('friend')
            ->get();

        // Récupérer les demandes d'amitié en attente envoyées
        $pendingSentRequests = $user->friends()
            ->where('status', 'pending')
            ->with('friend')
            ->get();

        // Récupérer les demandes d'amitié en attente reçues
        $pendingReceivedRequests = $user->friendRequests()
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('friends.index', compact(
            'acceptedFriends',
            'pendingSentRequests',
            'pendingReceivedRequests'
        ));
    }

    /**
     * Affiche le formulaire de recherche d'amis.
     */
    public function showSearchForm()
    {
        return view('friends.search');
    }

    /**
     * Recherche des utilisateurs par numéro de téléphone.
     */
    public function search(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        $currentUser = Auth::user();

        $users = User::where('phone_number', 'like', '%' . $request->phone_number . '%')
            ->where('id', '!=', $currentUser->id)
            ->limit(10)
            ->get();

        // Pour chaque utilisateur, vérifier s'il est déjà ami avec l'utilisateur courant
        foreach ($users as $user) {
            $friendship = Friend::where(function ($query) use ($currentUser, $user) {
                $query->where('user_id', $currentUser->id)
                    ->where('friend_id', $user->id);
            })->orWhere(function ($query) use ($currentUser, $user) {
                $query->where('user_id', $user->id)
                    ->where('friend_id', $currentUser->id);
            })->first();

            if ($friendship) {
                $user->friendship_status = $friendship->status;
                $user->is_sender = $friendship->user_id === $currentUser->id;
            } else {
                $user->friendship_status = null;
            }
        }

        return view('friends.search_results', compact('users'));
    }

    /**
     * Envoie une demande d'amitié.
     */
    public function sendRequest(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $friendId = $request->friend_id;

        // Vérifier que l'utilisateur n'essaie pas de s'ajouter lui-même
        if ($user->id == $friendId) {
            return back()->withErrors(['friend_id' => 'Vous ne pouvez pas vous ajouter vous-même comme ami.']);
        }

        // Vérifier si une relation d'amitié existe déjà
        $existingFriendship = Friend::where(function ($query) use ($user, $friendId) {
            $query->where('user_id', $user->id)
                ->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($user, $friendId) {
            $query->where('user_id', $friendId)
                ->where('friend_id', $user->id);
        })->first();

        if ($existingFriendship) {
            return back()->withErrors(['friend_id' => 'Une relation d\'amitié existe déjà avec cet utilisateur.']);
        }

        // Créer la demande d'amitié
        Friend::create([
            'user_id' => $user->id,
            'friend_id' => $friendId,
            'status' => 'pending',
        ]);

        return redirect()->route('friends.index')
            ->with('success', 'Demande d\'amitié envoyée avec succès.');
    }

    /**
     * Accepte une demande d'amitié.
     */
    public function acceptRequest(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friends,id',
        ]);

        $friendship = Friend::findOrFail($request->friendship_id);
        $user = Auth::user();

        // Vérifier que l'utilisateur est bien le destinataire de la demande
        if ($friendship->friend_id != $user->id) {
            return back()->withErrors(['general' => 'Vous n\'êtes pas autorisé à accepter cette demande.']);
        }

        // Mettre à jour le statut de la demande
        $friendship->update(['status' => 'accepted']);

        return redirect()->route('friends.index')
            ->with('success', 'Demande d\'amitié acceptée.');
    }

    /**
     * Refuse une demande d'amitié.
     */
    public function declineRequest(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friends,id',
        ]);

        $friendship = Friend::findOrFail($request->friendship_id);
        $user = Auth::user();

        // Vérifier que l'utilisateur est bien le destinataire de la demande
        if ($friendship->friend_id != $user->id) {
            return back()->withErrors(['general' => 'Vous n\'êtes pas autorisé à refuser cette demande.']);
        }

        // Mettre à jour le statut de la demande
        $friendship->update(['status' => 'declined']);

        return redirect()->route('friends.index')
            ->with('success', 'Demande d\'amitié refusée.');
    }

    /**
     * Supprimer une relation d'amitié.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friends,id',
        ]);

        $friendship = Friend::findOrFail($request->friendship_id);
        $user = Auth::user();

        // Vérifier que l'utilisateur est impliqué dans cette relation
        if ($friendship->user_id != $user->id && $friendship->friend_id != $user->id) {
            return back()->withErrors(['general' => 'Vous n\'êtes pas autorisé à supprimer cette relation.']);
        }

        // Supprimer la relation
        $friendship->delete();

        return redirect()->route('friends.index')
            ->with('success', 'Ami supprimé avec succès.');
    }
}
