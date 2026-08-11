<script setup lang="ts"></script>

<template>
    <main>
        <h1>Grocerly</h1>
        <form action="">
            <h3>Get started</h3>
            <p class="text-muted">Enter your name</p>
            <input type="text" name="" id="" required>
            <button type="submit">Enter</button>
        </form>
    </main>
</template>

<style scoped>
main {
    width: 100%;
    height: 100dvh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 50px;
    gap: 1rem;

}

form {
    border-radius: 4px;
    width: 100%;
    max-width: 400px;
    background-color: var(--bg-card);
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: left;
    padding: 50px;
    box-shadow: var(--shadow-md);
    gap: 1rem;
}

form p {
    font-weight: 500;
}
</style>
