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
    height: 50dvh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 50px;
    gap: 1rem;
}

.bento {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: .25rem;
    width: 90dvw;
}
</style>
