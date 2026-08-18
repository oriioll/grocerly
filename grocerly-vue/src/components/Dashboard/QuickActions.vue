<script setup lang="ts">

</script>

<template>
    <article class="quickActions">
        <h3>What are we gonna cook or buy today?</h3>
        <div class="buttons">
            <button type="button">+ New Recipe</button>
            <button type="button">+ New List</button>
        </div>
    </article>
</template>

<style scoped>
.quickActions {
    width: 100%;
    max-width: 800px;
    padding: 15px 30px;
    background-color: var(--bg-card);
    box-shadow: var(--shadow-md);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
}

.buttons {
    width: 100%;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}
</style>
