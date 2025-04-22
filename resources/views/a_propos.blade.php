<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>À propos - UCBinvestment</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .highlight {
      color: #0ea5e9; /* Bleu professionnel */
    }
    .fade-in {
      opacity: 0;
      transform: translateY(10px);
      animation: fadeInUp 1s ease forwards;
    }
    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body class="bg-white text-gray-800 font-sans leading-relaxed">

  <section class="max-w-5xl mx-auto px-6 py-16">
    <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-6">
      À propos de <span class="highlight">UCBinvestment</span>
    </h1>
    <p class="text-xl text-gray-600 mb-8">Bonjour et bienvenue sur <strong class="text-blue-700">UCB</strong> !</p>

    <p class="mb-6 text-gray-700">
      Fondée le <strong class="text-blue-700">26 décembre 2018</strong>, <strong class="text-blue-700">UCBinvestment</strong> est une plateforme innovante spécialisée dans la
      <span class="highlight font-semibold">vente de likes, de commentaires et de partages</span> pour les réseaux sociaux.
      Nous accompagnons les <strong>créateurs de contenu</strong>, <strong>influenceurs</strong> et <strong>entreprises</strong> dans leur quête de
      visibilité en ligne et de croissance digitale.
    </p>

    <h2 class="text-2xl md:text-3xl font-semibold text-blue-800 mt-12 mb-4">Nos services</h2>
    <p class="mb-4">Notre mission est double :</p>
    <ul class="list-disc list-inside space-y-3 text-gray-700 mb-8">
      <li><strong>Accroître la visibilité</strong> de nos clients grâce à des services sociaux de haute qualité.</li>
      <li><strong>Offrir aux utilisateurs une opportunité unique de gagner de l’argent</strong> en likant, commentant et partageant du contenu.</li>
    </ul>

    <p class="mb-10">Chez UCB, nous croyons fermement que <strong>votre temps et votre opinion ont de la valeur</strong>. C’est pourquoi nous vous récompensons pour votre engagement.</p>

    <h2 class="text-2xl md:text-3xl font-semibold text-blue-800 mt-12 mb-4">Nos engagements</h2>
    <ul class="space-y-4 mb-10 text-gray-700">
      <li>✅ <strong>Authenticité</strong> : Likes, commentaires et partages réels et de qualité</li>
      <li>⚡ <strong>Performance</strong> : Services rapides, fiables et efficaces</li>
      <li>🔒 <strong>Sécurité</strong> : Confidentialité et protection des données renforcées</li>
      <li>🤝 <strong>Support</strong> : Équipe dédiée, à l’écoute et réactive</li>
      <li>💸 <strong>Opportunités</strong> : Revenus réels en interagissant avec du contenu</li>
    </ul>

    <h2 class="text-2xl md:text-3xl font-semibold text-blue-800 mt-12 mb-4">Pourquoi nous choisir ?</h2>
    <p class="mb-6 text-gray-700">
      Parce que dans un monde numérique en constante évolution, <strong>la visibilité est essentielle</strong> pour réussir.
      Et parce que <strong>gagner de l’argent en faisant ce que vous aimez</strong>, c’est aussi possible.
    </p>

    <blockquote class="border-l-4 border-blue-400 pl-6 italic text-blue-700 bg-blue-50 py-4 px-2 rounded mb-12 shadow-sm">
      Rejoignez-nous dès aujourd’hui et découvrez comment booster votre présence en ligne ou commencer à générer des revenus dès maintenant.
    </blockquote>

    <div class="text-center mt-16">
      <h3 id="slogan" class="text-2xl md:text-3xl font-bold text-blue-900 fade-in">
        UCBinvestment — Sortez de la pauvreté, soyez heureux.
      </h3>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const slogan = document.getElementById('slogan');
      setTimeout(() => {
        slogan.classList.add('fade-in');
      }, 300);
    });
  </script>

</body>
</html>
