<script setup lang="ts">
//Importing vue elements and UserService to make api request
import { ref, type Ref } from 'vue';
import { useRouter } from 'vue-router';
import { UserService } from '@/services/UserService';
const router = useRouter();

//UI UX Variables
const name: Ref<string> = ref('');
const error: Ref<boolean> = ref(false);
const errorMsg: Ref<string> = ref('');
const isLoading: Ref<boolean> = ref(false);
//Instance user service to use its methods
const userService: UserService = new UserService();

/**
 * Makes API post request via createUser method from UserService to create the user with the input data
 */
const handleCreateUser = async () => {
    try {
        const trimmedName = name.value.trim();
        if (!trimmedName || isLoading.value) {
            throw new Error("Name can't be empty");
        }
        isLoading.value = true
        error.value = false
        errorMsg.value = ''
        await userService.createUser(trimmedName)
        router.push('/dashboard')
    } catch (error: any) {
        error.value = true
        errorMsg.value = error.message || 'Unexpected error'
    } finally {
        isLoading.value = false;
    }
}
</script>

<template>
    <main>
        <h1>Grocerly <svg class="logoSvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill="var(--accent-primary)"
                    d="M15.629 9.619c1.421 1.429 2.58 3.766 1.917 5.152c-1.778 3.715-15.04 10.226-16.169 9.1C.252 22.746 6.768 9.476 10.481 7.697c1.388-.66 3.724.51 5.152 1.92l-.005.014v-.012zm7.028-1.566c-.231-.855-.821-1.717-1.7-1.82c-1.61-.186-4.151 2.663-3.971 3.339c.181.69 3.766 1.875 5.1.915c.691-.494.781-1.56.556-2.414zM17.666.158c1.198.324 2.407 1.148 2.551 2.382c.261 2.259-3.732 5.819-4.68 5.564c-.948-.251-2.618-5.284-1.269-7.162c.695-.972 2.201-1.106 3.399-.788z" />
            </svg></h1>
        <form @submit.prevent="handleCreateUser">
            <h3>Get started</h3>
            <label for="name" class="text-muted">Enter your name</label>
            <input type="text" v-model="name" id="name" required>
            <p v-if="error" class="errorMessage">{{ errorMsg }}</p>
            <button v-if="isLoading" disabled type="button" aria-busy="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25">
                    <g fill="none" stroke="var(--bg-main)" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2">
                        <path stroke-dasharray="18" d="M12 3c4.97 0 9 4.03 9 9">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="18;0" />
                            <animateTransform attributeName="transform" dur="1s" repeatCount="indefinite" type="rotate"
                                values="0 12 12;360 12 12" />
                        </path>
                        <path stroke-dasharray="60"
                            d="M12 3c4.97 0 9 4.03 9 9c0 4.97 -4.03 9 -9 9c-4.97 0 -9 -4.03 -9 -9c0 -4.97 4.03 -9 9 -9Z"
                            opacity=".3">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.2s" values="60;0" />
                        </path>
                    </g>
                </svg>
            </button>
            <button v-else-if="name.trim() !== '' && !isLoading" type="submit" :disabled="false">Enter</button>
            <button v-else disabled class="btnDisabled" type="button">Enter</button>
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

.logoSvg {
    width: 30px;
    height: 30px;
}

button {
    transition: all .3s ease;
}

.errorMessage {
    color: #dc2626;
    font-size: 0.9rem;
    margin: 0;
}

.btnDisabled {
    cursor: not-allowed;
    opacity: .5;
    transition: all .3s ease;
}

@media (max-width: 1000px) {
    .logoSvg {
        width: 23px;
        height: 23px;
    }
}
</style>
