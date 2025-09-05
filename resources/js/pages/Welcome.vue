<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-100  text-[#1b1b18] lg:justify-center dark:bg-[#0a0a0a]">
        <div class="navbar border bg-white border-red-500 shadow-sm">
            <div class="flex-1">
                <a class="card-title text-xl text-red-600">SENAI-OM</a>
            </div>
            <div class="flex-none">
                <nav class="flex items-center justify-end gap-4">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                    Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')"
                            class="inline-block rounded-sm border shadow-sm border-red-500 px-5 py-1.5 text-sm leading-normal transition delay-100 ease-in-out text-red-600 hover:scale-110 hover:border-red-800 hover:bg-red-400 hover:text-white hover:shadow-md dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">
                        Entrar
                        </Link>
                        <!-- <Link :href="route('register')"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                        Cadastre-se
                        </Link> -->
                    </template>
                </nav>
            </div>
        </div>

        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <div class="card bg-base-100 w-96 h-96
             shadow-md">
                <div class="card-body">
                    <h2 class="card-title">SENAI-OM</h2>
                    <p>Bem vindo ao sistema SENAI para gerenciamento de ordens de manutenção</p>
                </div>
                <figure>
                    <img src="https://yt3.googleusercontent.com/wyGnsuVLCBoHStdhQ3Tj7Wr48yb_Oi2e1OmP2Rly99xB6wwe66T64bhCNDZkP5xxNHxF-lsE1A=s900-c-k-c0x00ffffff-no-rj"
                        alt="Shoes" />
                </figure>
            </div>
        </div>
        <footer class="footer border border-gray-300 sm:footer-horizontal footer-center bg-base-300 text-base-content p-4">
            <aside>
                <p>Desenvolvido por João Renan Celso. SENAI 5.03</p>
            </aside>
        </footer>
    </div>
</template>
