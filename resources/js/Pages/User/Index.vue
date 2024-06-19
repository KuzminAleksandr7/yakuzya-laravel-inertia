<script>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from "@/Layouts/MainLayout.vue";

export default {
    name: "Index",

    props: [
        'users'
    ],

    components: {
        Head,
        Link,
        MainLayout
    },

    methods: {
        // prevPage() {
        //     this.$inertia.get('/users/', { per_page: this.users.meta.per_page, page: --this.users.meta.current_page})
        // },
        // nextPage() {
        //     this.$inertia.get('/users/', { per_page: this.users.meta.per_page, page: ++this.users.meta.current_page})
        // },
        deleteUser(id) {
            this.$inertia.delete(`/users/${id}/delete`)
        }
    }
}
</script>

<template>
    <Head title="Users"/>

    <MainLayout>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-white uppercase bg-zinc-900">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Image</th>
                    <th scope="col" class="px-6 py-3">Firstname</th>
                    <th scope="col" class="px-6 py-3">Lastname</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data" class="odd:bg-zinc-100 even:bg-zinc-200 border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ user.id }}</th>
                    <td class="px-6 py-4">
                        <img :src="user.image === null ? '/assets/images/no_avatar.png' : user.image" class="w-10 h-10 rounded-full">
                    </td>
                    <td class="px-6 py-4">{{ user.firstname }}</td>
                    <td class="px-6 py-4">{{ user.lastname }}</td>
                    <td class="px-6 py-4">{{ user.email }}</td>
                    <td class="px-6 py-4 flex justify-center">
                        <Link :href="route('users.edit', user.id)" type="button" class="px-3 py-2 mr-1 text-xs font-medium text-center inline-flex items-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 mr-1">
                                <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                            </svg>
                            Edit
                        </Link>
                        <button @click="deleteUser(user.id)" type="button" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 mr-1">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                            </svg>
                            Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-if="users.meta.total > users.meta.per_page" class="flex flex-col items-center mb-6">
            <span class="text-sm text-gray-700">
                Showing <span class="font-semibold text-gray-900">{{ users.meta.from }}</span>
                to <span class="font-semibold text-gray-900">{{ users.meta.to }}</span>
                of <span class="font-semibold text-gray-900">{{ users.meta.total}}</span>
                Users
            </span>

            <div class="inline-flex mt-2 xs:mt-0">
                <button v-if="users.links.prev === null" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-zinc-200 rounded-s cursor-default">Prev</button>
<!--                <button @click.prevent="prevPage" v-else class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-zinc-900 rounded-s hover:bg-gray-900">Prev</button>-->
                <Link :href="route('users.index', { per_page: this.users.meta.per_page, page: this.users.meta.current_page - 1})" v-else  class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-zinc-900 rounded-s hover:bg-gray-900">Next</Link>

                <button v-if="users.links.next === null" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-zinc-200 border-0 border-s border-gray-700 rounded-e cursor-default">Next</button>
<!--                <button @click.prevent="nextPage" v-else  class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-zinc-900 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900">Next</button>-->
                <Link :href="route('users.index', { per_page: this.users.meta.per_page, page: this.users.meta.current_page + 1})" v-else  class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-zinc-900 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900">Next</Link>
            </div>
        </div>
    </MainLayout>
</template>
