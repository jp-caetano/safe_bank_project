<template>
    <div align="center" class="all-page">
        <v-img class="logo" max-width="350" src="http://localhost:8000/img/logo_oficial.png" contain></v-img>
        <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
            <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
                <div>
                    <div class="row">
                        <div align="left" class="col-md-4">
                            <button @click="backArrow">
                                <img src="http://localhost:8000/img/back_arrow.png" alt="Back button" style="height:2rem">
                            </button>
                        </div>
                        <div class="col-md-4 text-center">
                            <h1 class="text-h4 font-weight-black">Seu Perfil</h1>
                        </div>
                    </div>
                    <div align="center" style="margin-top: 30px;">
                        <h6 style="margin-top: 10px"><strong>Número da Conta:</strong> {{ user && user.id }}</h6>
                    </div>
                    <div align="center" style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                        <div class="col-md-4">
                            <h6 style="margin-top: 10px"><strong>Nome completo:</strong></h6>
                            <p>{{ user && user.name }}</p>

                            <h6 style="margin-top: 10px"><strong>Nacionalidade:</strong></h6>
                            <p>{{ user && user.nationality }}</p>
                        </div>

                        <div class="col-md-4">
                            <h6 style="margin-top: 10px"><strong>CPF:</strong></h6>
                            <p>{{ user && user.cpf }}</p>

                            <h6 style="margin-top: 10px"><strong>RG:</strong></h6>
                            <p> {{ user && user.rg }}</p>
                        </div>

                        <div class="col-md-4">
                            <h6 style="margin-top: 10px"><strong>E-mail:</strong></h6>
                            <p>{{ user && user.email }}</p>

                            <h6 style="margin-top: 10px"><strong>Telefone:</strong></h6>
                            <p>{{ user && user.phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import { request } from '../helper';

export default {
    setup() {
        const user = ref()
        const isLoading = ref()

        let router = useRouter();
        onMounted(() => {
            authentication()
        });

        const authentication = async () => {
            isLoading.value = true
            try {
                const req = await request('get', '/api/user')
                user.value = req.data
            } catch (e) {
                await router.push('/login')
                alert("Sessão expirada, necessário novo login!");
            }
        }

        const backArrow = () => {
            router.push('main')
        }

        return {
            user,
            backArrow,
            isLoading
        }
    },
}
</script>

<style scoped>
/* Estilos CSS específicos para este componente */
.all-page {
    background-color: #010022;
    min-height: 100vh;
    font-family: 'kanit', sans-serif;
    /* Configurações aplicadas em toda a página */
}

.logo {
    margin-bottom: 20px;
    /* Margem inferior para a logo */
}
</style>