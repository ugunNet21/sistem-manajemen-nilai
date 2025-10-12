<!--js/Pages/Auth/Register.vue-->
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import EnhancedButton from '@/Components/EnhancedButton.vue';
import EnhancedTextInput from '@/Components/EnhancedTextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Daftar SistemNilai" />

    <AuthenticationCard background="gradient">
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Name Input -->
            <div>
                <InputLabel value="Nama Lengkap" required helper="Masukkan nama lengkap Anda" />
                <EnhancedTextInput
                    v-model="form.name"
                    type="text"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                    autofocus
                    autocomplete="name"
                    icon="fas fa-user"
                    :error="form.errors.name"
                />
            </div>

            <!-- Email Input -->
            <div>
                <InputLabel value="Alamat Email" required helper="Gunakan email sekolah yang valid" />
                <EnhancedTextInput
                    v-model="form.email"
                    type="email"
                    placeholder="nama@sekolah.com"
                    required
                    autocomplete="username"
                    icon="fas fa-envelope"
                    :error="form.errors.email"
                />
            </div>

            <!-- Password Input -->
            <div>
                <InputLabel value="Kata Sandi" required helper="Minimal 8 karakter dengan kombinasi huruf dan angka" />
                <EnhancedTextInput
                    v-model="form.password"
                    type="password"
                    placeholder="Buat kata sandi yang kuat"
                    required
                    autocomplete="new-password"
                    icon="fas fa-lock"
                    :error="form.errors.password"
                />
            </div>

            <!-- Confirm Password Input -->
            <div>
                <InputLabel value="Konfirmasi Kata Sandi" required />
                <EnhancedTextInput
                    v-model="form.password_confirmation"
                    type="password"
                    placeholder="Ulangi kata sandi Anda"
                    required
                    autocomplete="new-password"
                    icon="fas fa-lock"
                    :error="form.errors.password_confirmation"
                />
            </div>

            <!-- Terms Agreement -->
            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" 
                 class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                <label class="flex items-start space-x-3 cursor-pointer">
                    <Checkbox id="terms" v-model:checked="form.terms" name="terms" required class="mt-1" />
                    <div class="text-sm text-gray-700">
                        Saya setuju dengan 
                        <a target="_blank" :href="route('terms.show')" class="text-blue-600 hover:text-blue-700 font-medium">Syarat Layanan</a> 
                        dan 
                        <a target="_blank" :href="route('policy.show')" class="text-blue-600 hover:text-blue-700 font-medium">Kebijakan Privasi</a>
                    </div>
                </label>
                <InputError class="mt-2" :message="form.errors.terms" />
            </div>

            <!-- Submit Button -->
            <EnhancedButton
                type="submit"
                variant="primary"
                size="large"
                :loading="form.processing"
                :disabled="form.processing"
                fullWidth
                icon="fas fa-user-plus"
            >
                Daftar Sekarang
            </EnhancedButton>

            <!-- Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-gray-600 text-sm">
                    Sudah punya akun?
                    <Link :href="route('login')" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors ml-1">
                        Masuk di sini
                    </Link>
                </p>
            </div>

            <!-- Benefits Info -->
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-blue-200 animate-fade-in">
                <h3 class="text-sm font-semibold text-blue-800 mb-3 flex items-center space-x-2">
                    <i class="fas fa-star text-yellow-500"></i>
                    <span>Keuntungan Bergabung</span>
                </h3>
                <ul class="text-xs text-blue-700 space-y-2">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Kelola nilai siswa dengan mudah</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Generate laporan otomatis</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Akses dari perangkat apapun</span>
                    </li>
                </ul>
            </div>
        </form>
    </AuthenticationCard>
</template>