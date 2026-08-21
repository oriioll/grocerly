<script setup lang="ts">
import { ref, onBeforeMount } from 'vue';
import { useRouter } from 'vue-router';
import QuickActions from '@/components/Dashboard/QuickActions.vue';
import RecentActivity from '@/components/Dashboard/RecentActivity.vue';

const router = useRouter();
const user = ref('');

onBeforeMount(async () => {
    try {
        user.value = localStorage.getItem('name') || 'Guest';
    } catch (error: any) {
        console.log(error)
        router.push('/register');
    }
})
</script>

<template>
    <main>
        <h1>Hello, {{ user }}! </h1>
        <section class="bento">
            <QuickActions />
            <RecentActivity />
        </section>
    </main>
</template>

<style scoped>
main {
    width: 100%;
    min-height: 100dvh;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    padding: clamp(2rem, 8vh, 5rem) 1rem 2rem;
    gap: 1rem;
}

main h1 {
    max-width: 100%;
    text-align: center;
    overflow-wrap: anywhere;
}

.bento {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: .25rem;
    width: 90dvw;
    max-width: 100%;
}
</style>
