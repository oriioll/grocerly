<script setup lang="ts">
import router from '@/router';
import type { ShoppingList } from '@/types/shoppingList';

const props = defineProps<{
    list: ShoppingList
}>()

const openList = () => {
    router.push("/shopping-lists/" + props.list.listId)
}
</script>

<template>
    <div class="card" @click="openList">
        <p>{{ props.list.foods.length }} items</p>
    </div>
</template>

<style scoped>
.card {
    width: 100%;
    padding: 5px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: .25rem;
    border: solid 1px var(--border-color);
    cursor: pointer;
    transition: all .2s ease;
}

.card:hover {
    transform: translateY(-1px);
}
</style>
