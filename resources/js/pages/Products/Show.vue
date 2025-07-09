<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Product } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    product: Product;
}

const props = defineProps<Props>();
const image = props.product.image ? `/storage/products/${props.product.image}` : '/storage/products/product_placeholder.png';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index'),
    },
    {
        title: props.product.name,
        href: '',
    },
];
</script>

<template>
    <Head title="Show Product" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div>
                <TextLink :href="route('products.edit', props.product.id)" prefetch>Edit</TextLink>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <p>Show Product</p>
                <p>{{ props.product.name }}</p>
                <p>{{ props.product.description ?? 'No description.' }}</p>
                <p>{{ props.product.price }}</p>
                <img :src="image" alt="Product Image" class="h-72 w-72 object-fill" />
            </div>
        </div>
    </AppLayout>
</template>
