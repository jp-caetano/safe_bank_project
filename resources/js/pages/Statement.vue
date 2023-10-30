<template>
    <div align="center" class="all-page">
        <v-img class="logo" max-width="350" src="http://localhost:8000/img/logo_oficial.png" contain></v-img>
        <div class="mx-auto w-5/12 mt-10 bg-blue-200 p-4 rounded-lg">
            <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
                <div>
                    <div class="row">
                        <div align="left" class="col-md-4">
                            <button @click="backArrow">
                                <img src="http://localhost:8000/img/back_arrow.png" alt="Back button" style="height:2rem">
                            </button>
                        </div>
                        <div class="col-md-4 text-center">
                            <h1 class="text-h4 font-weight-black">Extrato</h1>
                        </div>
                    </div>
                    <table style="width: 100%; height: 100%; margin-top: 20px; padding: 0;">
                        <thead>
                            <tr>
                                <th align="left">Data</th>
                                <th align="left">Descrição</th>
                                <th align="right">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in transactions" :key="transaction.id">
                                <td align="left">{{ transaction.created_at }}</td>
                                <td align="left">{{ transaction.description }}</td>
                                <td align="right">{{ transaction.amount }}</td>
                            </tr>
                            <tr class="font-weight-black pt-5" style="margin-top: 5px;">
                                <td align="left" colspan="2"> Saldo Disponível:</td>
                                <td align="right">R${{ user && user.balance }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import { request } from '../helper';
import { format } from 'date-fns';

export default {
    setup() {
        const user = ref()
        const transactions = ref([]);
        const isLoading = ref()

        let router = useRouter();
        onMounted(() => {
            authentication(),
                getTransactions()
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

        const getTransactions = async () => {
            isLoading.value = true
            try {
                const response = await request('get', '/api/account/transactions');
                transactions.value = response.data.map(transaction => ({
                    ...transaction,
                    created_at: format(new Date(transaction.created_at), 'dd/MM/yyyy'),
                    amount: parseFloat(transaction.amount).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                    }),
                }));
            } catch (e) {
                await router.push('/')
            }
        }

        const backArrow = () => {
            router.push('main')
        }

        return {
            user,
            backArrow,
            isLoading,
            transactions
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