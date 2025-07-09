<script setup lang="ts">
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import TextLink from '@/components/TextLink.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index'),
    },
];

interface Props {
    products: Product[];
}

const props = defineProps<Props>();
</script>

<template>

    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <TextLink :href="route('products.create')" prefetch class="underline underline-offset-4" :tabindex="6">
                    Create Product</TextLink>
                <div class="mt-4 grid auto-rows-min gap-4 md:grid-cols-3">
                    <div v-for="product in props.products" :key="product.id"
                        class="flex flex-col gap-3 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                        <p>Name: {{ product.name }}</p>
                        <p>Description: {{ product.description }}</p>
                        <p>Price: {{ product.price }}</p>
                        <div class="flex justify-evenly ">
                            <TextLink :href="route('products.show', product.id)" prefetch>Show</TextLink>
                            <TextLink :href="route('products.destroy', product.id)" :as="'button'" :method="'delete'">
                                Delete
                            </TextLink>
                        </div>
                        <img :src="product.image" loading="lazy" alt="Product image" class="h-72 w-72 object-contain" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
