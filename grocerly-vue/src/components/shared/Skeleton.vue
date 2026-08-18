<template>
    <div class="skeleton-wrapper">
        <div class="skeleton-heading"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-text short"></div>
    </div>
</template>

<style scoped>
.skeleton-wrapper {
    box-shadow: var(--shadow-md);
    background-color: var(--bg-card);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
}

/* Base de color gris con animación de parpadeo suave */
.skeleton-heading,
.skeleton-text {
    background-color: #e2e8f0;
    border-radius: 6px;
    animation: pulse 1.5s infinite ease-in-out;
}

.skeleton-heading {
    height: 24px;
    width: 60%;
    margin-bottom: 8px;
}

.skeleton-text {
    height: 16px;
    width: 100%;
}

.skeleton-text.short {
    width: 80%;
}

/* L'animació que dóna l'efecte de càrrega */
@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.4;
    }
    100% {
        opacity: 1;
    }
}
</style>