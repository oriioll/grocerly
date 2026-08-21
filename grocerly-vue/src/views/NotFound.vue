<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
    <main class="not-found">
        <div class="content-wrapper">
            <!-- Gran 404 con el logo intercalado o encima -->
            <div class="error-visual">
                <span class="error-code">4</span>
                <svg class="logoSvg pulse-animation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="var(--accent-primary)"
                        d="M15.629 9.619c1.421 1.429 2.58 3.766 1.917 5.152c-1.778 3.715-15.04 10.226-16.169 9.1C.252 22.746 6.768 9.476 10.481 7.697c1.388-.66 3.724.51 5.152 1.92l-.005.014v-.012zm7.028-1.566c-.231-.855-.821-1.717-1.7-1.82c-1.61-.186-4.151 2.663-3.971 3.339c.181.69 3.766 1.875 5.1.915c.691-.494.781-1.56.556-2.414zM17.666.158c1.198.324 2.407 1.148 2.551 2.382c.261 2.259-3.732 5.819-4.68 5.564c-.948-.251-2.618-5.284-1.269-7.162c.695-.972 2.201-1.106 3.399-.788z" />
                </svg>
                <span class="error-code">4</span>
            </div>

            <!-- Textos descriptivos -->
            <h1 class="title">Aisle 404 is completely empty</h1>
            <p class="description text-muted">
                Looks like this recipe is missing a few ingredients. The page you are looking for doesn't exist, has
                been moved, or was eaten.
            </p>

            <!-- CTA de vuelta -->
            <router-link to="/dashboard" class="btn-return">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Return to Dashboard
            </router-link>
        </div>
    </main>
</template>

<style scoped>
.not-found {
    width: 100%;
    height: 100dvh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    background-color: var(--bg-main);
}

.content-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    max-width: 500px;
}

/* El bloque visual del 404 */
.error-visual {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* Variable tipográfica local solo para este número gigante */
.error-code {
    font-size: clamp(6rem, 15vw, 9rem);
    font-weight: 800;
    color: var(--text-main);
    line-height: 1;
    letter-spacing: -0.05em;
}

/* La zanahoria gigante que hace de '0' */
.logoSvg {
    width: clamp(5rem, 12vw, 7.5rem);
    height: clamp(5rem, 12vw, 7.5rem);
    transform: rotate(15deg);
}

/* Animación sutil de respiración para la zanahoria */
.pulse-animation {
    animation: float 4s ease-in-out infinite;
}

@keyframes float {
    0% {
        transform: translateY(0px) rotate(15deg);
    }

    50% {
        transform: translateY(-10px) rotate(10deg);
    }

    100% {
        transform: translateY(0px) rotate(15deg);
    }
}

.title {
    font-size: var(--h2-size);
    margin-bottom: 0.75rem;
    color: var(--text-main);
}

.description {
    font-size: var(--p-size);
    margin-bottom: 2.5rem;
    line-height: 1.6;
}

/* Estilo del botón adaptado a router-link */
.btn-return {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: var(--accent-primary);
    color: var(--bg-card);
    padding: 12px 24px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: var(--p-size);
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: var(--shadow-md);
}

.btn-return:hover {
    background-color: var(--accent-primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 138, 101, 0.25);
    text-decoration: none;
    /* Override del a:hover global */
}

/* Responsivo */
@media (max-width: 480px) {
    .error-visual {
        gap: 0.5rem;
    }

    .btn-return {
        width: 100%;
        justify-content: center;
    }
}
</style>