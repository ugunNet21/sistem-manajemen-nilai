<!--js/Pages/Auth/Login.vue-->
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import EnhancedButton from '@/Components/EnhancedButton.vue';
import EnhancedTextInput from '@/Components/EnhancedTextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Masuk ke SistemNilai" />

    <AuthenticationCard background="gradient">
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <!-- Status Message -->
        <div v-if="status" class="mb-6 animate-slide-up">
            <InputError :message="status" type="success" />
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Input -->
            <div>
                <InputLabel value="Alamat Email" required />
                <EnhancedTextInput
                    v-model="form.email"
                    type="email"
                    placeholder="masukkan.email@sekolah.com"
                    required
                    autofocus
                    autocomplete="username"
                    icon="fas fa-envelope"
                    :error="form.errors.email"
                />
            </div>

            <!-- Password Input -->
            <div>
                <InputLabel value="Kata Sandi" required />
                <EnhancedTextInput
                    v-model="form.password"
                    type="password"
                    placeholder="Masukkan kata sandi Anda"
                    required
                    autocomplete="current-password"
                    icon="fas fa-lock"
                    :error="form.errors.password"
                />
            </div>

            <!-- Remember & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-3 cursor-pointer group">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="text-sm text-gray-700 font-medium group-hover:text-gray-900 transition-colors">
                        Ingat saya
                    </span>
                </label>

                <Link 
                    v-if="canResetPassword" 
                    :href="route('password.request')" 
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors flex items-center space-x-1"
                >
                    <i class="fas fa-key"></i>
                    <span>Lupa kata sandi?</span>
                </Link>
            </div>

            <!-- Submit Button -->
            <EnhancedButton
                type="submit"
                variant="primary"
                size="large"
                :loading="form.processing"
                :disabled="form.processing"
                fullWidth
                icon="fas fa-sign-in-alt"
            >
                Masuk ke Sistem
            </EnhancedButton>

            <!-- Register Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Belum punya akun?
                    <Link :href="route('register')" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors ml-1">
                        Daftar Sekarang
                    </Link>
                </p>
            </div>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200 animate-fade-in">
                <h3 class="text-sm font-semibold text-blue-800 mb-3 flex items-center space-x-2">
                    <i class="fas fa-info-circle"></i>
                    <span>Info Login Demo</span>
                </h3>
                <div class="text-xs text-blue-700 space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Email:</span>
                        <code class="bg-blue-100 px-2 py-1 rounded">admin@sekolahku.com</code>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium">Password:</span>
                        <code class="bg-blue-100 px-2 py-1 rounded">password</code>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>