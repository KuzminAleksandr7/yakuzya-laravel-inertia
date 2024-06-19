<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import MainLayout from "@/Layouts/MainLayout.vue";
import { ref } from 'vue'

defineProps({ errors: Object })

const form = useForm({
    firstname: null,
    lastname: null,
    email: null,
    image: null,
    password: null,
    password_confirmation: null,
})

const previewUrl = ref(null)
function previewImage(event) {
    const file = event.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = () => {
            previewUrl.value = reader.result
        }
        reader.readAsDataURL(file)
    } else {
        previewUrl.value = null
    }
}

function store() {
    router.post('/users', form)
}
</script>

<template>
    <Head title="Create user" />

    <MainLayout>

        <form @submit.prevent="store" class="w-full sm:w-96 lg:w-3/4 mx-auto">
            <div class="mb-5 flex items-center space-x-4">
                <img v-if="previewUrl" :src="previewUrl" class="w-20 h-20 rounded-full object-cover" alt="Preview Image" />
                <img v-else src="/assets/images/no_avatar.png" class="w-20 h-20 rounded-full object-cover" alt="No avatar" />
                <div class="w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="user_avatar">Upload avatar</label>
                    <input @input="form.image = $event.target.files[0]" @change="previewImage" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none" aria-describedby="user_avatar_help" id="user_avatar" type="file" accept=".jpg,.jpeg,.png,.svg,.webp">
                    <p v-if="errors.image" class="mt-2 text-sm text-red-600">{{ errors.image }}</p>
                </div>
            </div>

            <div class="mb-3">
                <label for="firstname" class="block mb-2 text-sm font-medium text-black">Firstname</label>
                <input v-model="form.firstname" type="text" id="firstname" :class="errors.firstname ? 'border-red-300' : 'border-gray-300'" class="border text-gray-700 focus:ring-gray-500 placeholder-gray-400 text-sm rounded-lg block w-full py-0.5 px-2.5" placeholder="Enter firstname">
                <p v-if="errors.firstname" class="mt-2 text-sm text-red-600">{{ errors.firstname }}</p>
            </div>
            <div class="mb-3">
                <label for="lastname" class="block mb-2 text-sm font-medium text-black">Lastname</label>
                <input v-model="form.lastname" type="text" id="lastname" :class="errors.lastname ? 'border-red-300' : 'border-gray-300'" class="border text-gray-700 focus:ring-gray-500 placeholder-gray-400 text-sm rounded-lg block w-full py-0.5 px-2.5" placeholder="Enter lastname">
                <p v-if="errors.lastname" class="mt-2 text-sm text-red-600">{{ errors.lastname }}</p>
            </div>
            <div class="mb-3">
                <label for="email" class="block mb-2 text-sm font-medium text-black">Email</label>
                <input v-model="form.email" type="text" id="email" :class="errors.email ? 'border-red-300' : 'border-gray-300'" class="border text-gray-700 focus:ring-gray-500 placeholder-gray-400 text-sm rounded-lg block w-full py-0.5 px-2.5" placeholder="Enter email">
                <p v-if="errors.email" class="mt-2 text-sm text-red-600">{{ errors.email }}</p>
            </div>
            <div class="mb-3">
                <label for="password" class="block mb-2 text-sm font-medium text-black">Password</label>
                <input v-model="form.password" type="password" id="password" :class="errors.password ? 'border-red-300' : 'border-gray-300'" class="border text-gray-700 focus:ring-gray-500 placeholder-gray-400 text-sm rounded-lg block w-full py-0.5 px-2.5" placeholder="Enter password" />
                <p v-if="errors.password" class="mt-2 text-sm text-red-600">{{ errors.password }}</p>
            </div>
            <div class="mb-8">
                <label for="confirmPassword" class="block mb-2 text-sm font-medium text-black">Confirm password</label>
                <input v-model="form.password_confirmation" type="password" id="confirmPassword" class="border border-gray-300 focus:ring-gray-500 text-gray-700 placeholder-gray-400 text-sm rounded-lg block w-full py-0.5 px-2.5" placeholder="Repeat the entered password" />
            </div>

            <div>
                <button type="submit" :disabled="form.processing" class="focus:outline-none text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Save</button>
            </div>
        </form>

    </MainLayout>
</template>
