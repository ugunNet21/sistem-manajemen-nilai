<!-- resources/js/Components/Admin/AdminHeader.vue -->
<script setup>
import { usePage, router, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';

defineEmits(['toggle-sidebar']);

const user = usePage().props.auth.user;
const dropdownOpen = ref(false);
const searchQuery = ref('');
const showSuggestions = ref(false);
const suggestions = ref([]);
const isLoading = ref(false);

const limitName = (name, maxLength = 20) => {
    if (name.length <= maxLength) return name;
    return name.substring(0, maxLength) + '...';
};

const logout = () => {
    router.post(route('logout'));
};

const closeDropdown = (event) => {
    if (!event.target.closest('.user-dropdown')) {
        dropdownOpen.value = false;
    }
};

// Autocomplete search
const fetchSuggestions = debounce(async (query) => {
    if (query.length < 2) {
        suggestions.value = [];
        showSuggestions.value = false;
        return;
    }

    isLoading.value = true;
    
    try {
        const response = await fetch(route('admin.search.autocomplete') + `?q=${encodeURIComponent(query)}`);
        const data = await response.json();
        suggestions.value = data;
        showSuggestions.value = data.length > 0;
    } catch (error) {
        console.error('Error fetching suggestions:', error);
        suggestions.value = [];
    } finally {
        isLoading.value = false;
    }
}, 300);

// Watch search query changes
watch(searchQuery, (newQuery) => {
    if (newQuery.trim()) {
        fetchSuggestions(newQuery.trim());
    } else {
        suggestions.value = [];
        showSuggestions.value = false;
    }
});

const performSearch = () => {
    if (searchQuery.value.trim()) {
        showSuggestions.value = false;
        router.get(route('admin.search'), {
            q: searchQuery.value.trim()
        });
    }
};

const handleSearchKeypress = (event) => {
    if (event.key === 'Enter') {
        performSearch();
    }
};

const selectSuggestion = (suggestion) => {
    searchQuery.value = suggestion.text;
    showSuggestions.value = false;
    router.visit(suggestion.url);
};

const closeSuggestions = () => {
    setTimeout(() => {
        showSuggestions.value = false;
    }, 200);
};

if (typeof window !== 'undefined') {
    document.addEventListener('click', closeDropdown);
}
</script>

<template>
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="flex items-center justify-between px-6 py-4">
            <button @click="$emit('toggle-sidebar')" class="lg:hidden">
                <i class="fas fa-bars text-2xl text-gray-700"></i>
            </button>

            <div class="flex-1 max-w-2xl mx-4 relative">
                <div class="relative">
                    <input
                        type="text"
                        v-model="searchQuery"
                        @keypress="handleSearchKeypress"
                        @blur="closeSuggestions"
                        @focus="searchQuery.trim() && (showSuggestions = true)"
                        placeholder="Cari siswa, nilai, mapel, atau kelas..."
                        class="w-full pl-10 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    
                    <!-- Loading spinner -->
                    <div v-if="isLoading" class="absolute right-10 top-2">
                        <i class="fas fa-spinner fa-spin text-gray-400"></i>
                    </div>
                    
                    <button 
                        @click="performSearch"
                        class="absolute right-3 top-2 p-1 text-gray-500 hover:text-blue-600 transition"
                        :disabled="!searchQuery.trim()"
                        :class="{ 'text-blue-600': searchQuery.trim() }"
                    >
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>

                <!-- Autocomplete Suggestions -->
                <div v-if="showSuggestions && suggestions.length > 0" 
                     class="absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-50 max-h-80 overflow-y-auto">
                    <div v-for="suggestion in suggestions" :key="suggestion.text"
                         @mousedown="selectSuggestion(suggestion)"
                         class="p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800 flex items-center">
                                    <i v-if="suggestion.type === 'student'" class="fas fa-user text-blue-500 mr-2 text-sm"></i>
                                    <i v-else-if="suggestion.type === 'subject'" class="fas fa-book text-green-500 mr-2 text-sm"></i>
                                    <i v-else-if="suggestion.type === 'grade'" class="fas fa-chart-bar text-purple-500 mr-2 text-sm"></i>
                                    {{ suggestion.text }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">{{ suggestion.subtext }}</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian user dropdown-->
            <div class="flex items-center space-x-4">
                <!-- Notifikasi -->
                <button class="relative p-2 hover:bg-gray-100 rounded-full">
                    <i class="fas fa-bell text-xl text-gray-600"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Info User dengan Dropdown -->
                <div class="relative user-dropdown">
                    <button @click="dropdownOpen = !dropdownOpen"
                        class="flex items-center space-x-3 border-l pl-4 focus:outline-none">
                        <img :src="`https://ui-avatars.com/api/?name=${user.name}&background=3B82F6&color=fff`"
                            class="w-10 h-10 rounded-full border-2 border-gray-200" :alt="user.name" />
                        <div class="hidden md:block text-right">
                            <p class="text-sm font-semibold text-gray-800">
                                {{ limitName(user.name) }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ user.email ? limitName(user.email, 25) : '' }}
                            </p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-500 text-xs transition-transform duration-200"
                            :class="{ 'rotate-180': dropdownOpen }"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div v-if="dropdownOpen"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                        <!-- Info User di Dropdown -->
                        <div class="px-4 py-2 border-b border-gray-100 md:hidden">
                            <p class="text-sm font-semibold text-gray-800">{{ user.name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ user.email }}</p>
                        </div>

                        <!-- Menu Items -->
                        <Link :href="route('profile.show')"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-user mr-2"></i>
                        Profile
                        </Link>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-cog mr-2"></i>
                            Settings
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <button @click="logout"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>