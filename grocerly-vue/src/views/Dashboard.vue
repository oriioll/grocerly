<script setup lang="ts">
import { ref, onMounted, onBeforeMount } from 'vue';
import { useRouter } from 'vue-router';
import { UserService } from '@/services/UserService';

const router = useRouter();
const user = ref('');
const userService = new UserService();

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
        <h1>Hello, {{ user }} </h1>
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
</style>
