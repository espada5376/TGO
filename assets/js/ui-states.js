/**
 * TogoMarket — ui-states.js
 * Composants réutilisables pour les états vide et erreur.
 */

/**
 * Affiche un état vide dans un conteneur DOM.
 * @param {HTMLElement} container  - Élément cible
 * @param {string}      message    - Texte à afficher (optionnel)
 */
function emptyState(container, message = 'Aucun résultat pour le moment.') {
    container.innerHTML = '';
    const el = document.createElement('div');
    el.className = 'state-empty';
    el.innerHTML = `
        <svg class="state-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="1.5"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M22 12h-6l-2 3H10l-2-3H2"/>
            <path d="M5.45 5.11L2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6L18.55 5.11A2 2 0 0016.76 4H7.24a2 2 0 00-1.79 1.11z"/>
        </svg>
        <p class="state-title">${message}</p>
    `;
    container.appendChild(el);
}

/**
 * Affiche un état d'erreur dans un conteneur DOM.
 * @param {HTMLElement}   container - Élément cible
 * @param {string}        message   - Description de l'erreur (optionnel)
 * @param {Function|null} onRetry   - Callback du bouton "Réessayer" (null = pas de bouton)
 */
function errorState(container, message = 'Une erreur est survenue. Vérifiez votre connexion.', onRetry = null) {
    container.innerHTML = '';
    const el = document.createElement('div');
    el.className = 'state-error';
    el.innerHTML = `
        <svg class="state-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="1.5"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <p class="state-title">Oups !</p>
        <p class="state-msg">${message}</p>
        ${onRetry ? '<button class="state-retry" type="button">Réessayer</button>' : ''}
    `;
    if (onRetry) {
        el.querySelector('.state-retry').addEventListener('click', onRetry);
    }
    container.appendChild(el);
}
