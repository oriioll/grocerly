<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
    <main class="landing">
        <!-- NAVBAR -->
        <nav class="navbar">
            <div class="logo">
                <svg class="logoSvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="var(--accent-primary)"
                        d="M15.629 9.619c1.421 1.429 2.58 3.766 1.917 5.152c-1.778 3.715-15.04 10.226-16.169 9.1C.252 22.746 6.768 9.476 10.481 7.697c1.388-.66 3.724.51 5.152 1.92l-.005.014v-.012zm7.028-1.566c-.231-.855-.821-1.717-1.7-1.82c-1.61-.186-4.151 2.663-3.971 3.339c.181.69 3.766 1.875 5.1.915c.691-.494.781-1.56.556-2.414zM17.666.158c1.198.324 2.407 1.148 2.551 2.382c.261 2.259-3.732 5.819-4.68 5.564c-.948-.251-2.618-5.284-1.269-7.162c.695-.972 2.201-1.106 3.399-.788z" />
                </svg>
                <span class="logo-text">Grocerly</span>
            </div>
            <router-link to="/register" class="btn-outline">Sign In</router-link>
        </nav>

        <!-- HERO SECTION -->
        <header class="hero">
            <h1 class="hero-title">Your meals and groceries,<br> <span class="highlight">centralized.</span></h1>
            <p class="hero-subtitle">Stop guessing what to buy. Build custom recipes, organize smart shopping lists, and
                manage your kitchen effortlessly.</p>
            <router-link to="/register" class="btn-primary">Start Planning Free</router-link>
        </header>

        <!-- FEATURES SECTION -->
        <section class="features">
            <div class="feature-card">
                <div class="feature-icon recipe-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20"></path>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <h3>Custom Recipes</h3>
                <p class="text-muted">Create and store your favorite meals using our massive, pre-defined food database.
                    No more manual typing.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon list-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </div>
                <h3>Smart Shopping</h3>
                <p class="text-muted">Turn your recipe ingredients into organized shopping lists with a single tap.
                    Never forget an item again.</p>
            </div>
        </section>

        <footer class="footer">
            <p class="text-muted text-sm">© 2026 Grocerly App. All rights reserved.</p>
        </footer>
    </main>
</template>

<style scoped>
.landing {
    width: 100%;
    min-height: 100dvh;
    display: flex;
    flex-direction: column;
    background-color: var(--bg-main);
}

/* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 5%;
    max-width: 1200px;
    width: 100%;
    margin: 0 auto;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logoSvg {
    width: 28px;
    height: 28px;
}

.logo-text {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-main);
    letter-spacing: -0.02em;
}

/* BOTONES */
.btn-primary {
    background-color: var(--accent-primary);
    color: var(--bg-card);
    padding: 12px 28px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: var(--p-size);
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
    background-color: var(--accent-primary-hover);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 138, 101, 0.25);
    text-decoration: none;
}

.btn-outline {
    border: 2px solid var(--border-color);
    color: var(--text-main);
    padding: 8px 20px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    border-color: var(--accent-primary);
    color: var(--accent-primary);
    text-decoration: none;
}

/* HERO SECTION */
.hero {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 4rem 20px;
    max-width: 800px;
    margin: 0 auto;
}

.hero-title {
    font-size: clamp(2.5rem, 6vw, 4rem);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1.5rem;
}

.highlight {
    color: var(--accent-primary);
}

.hero-subtitle {
    font-size: var(--h4-size);
    color: var(--text-muted);
    margin-bottom: 2.5rem;
    max-width: 600px;
}

/* FEATURES */
.features {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 2rem;
    padding: 4rem 20px;
    max-width: 1000px;
    margin: 0 auto;
    width: 100%;
}

.feature-card {
    background-color: var(--bg-card);
    padding: 2.5rem;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
}

.feature-icon {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-sm);
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 1.5rem;
}

.recipe-icon {
    background-color: var(--accent-primary-light);
    color: var(--accent-primary);
}

.list-icon {
    background-color: var(--accent-secondary-light);
    color: var(--accent-secondary);
}

.feature-card h3 {
    margin-bottom: 0.5rem;
    font-size: var(--h3-size);
}

/* FOOTER */
.footer {
    text-align: center;
    padding: 2rem;
    border-top: 1px solid var(--border-color);
    margin-top: auto;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .features {
        flex-direction: column;
    }

    .hero {
        padding: 2rem 20px;
    }
}
</style>