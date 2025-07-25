<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: route('users.index'),
    },
];

interface Props {
    users: User[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <TextLink :href="route('users.create')" prefetch class="underline underline-offset-4">Create User </TextLink>
                <div class="mt-4 grid auto-rows-min gap-4 p-3 md:grid-cols-3">
                    <div
                        v-for="(user, index) in users"
                        :key="index"
                        class="flex flex-col gap-3 rounded-xl border border-sidebar-border/70 p-3 dark:border-sidebar-border"
                    >
                        <p>Name: {{ user.name }}</p>
                        <p>Email: {{ user.email }}</p>
                        <p>Email Verified At: {{ user.email_verified_at }}</p>
                        <p>Created At: {{ user.created_at }}</p>
                        <p>Updated At: {{ user.updated_at }}</p>
                        <div class="flex justify-end pr-5 pb-3">
                            <TextLink :href="route('products.destroy', user.id)" :as="'button'" :method="'delete'"> Delete </TextLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
