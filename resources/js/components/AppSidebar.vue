<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ChartArea, LayoutGrid, Notebook, NotebookPen, UserRoundPlus, Users } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { getTenantId } from '@/lib/utils';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard', getTenantId()),
        icon: LayoutGrid,
    },
    {
        title: 'List Children Events',
        href: route('event.list', getTenantId()),
        icon: Notebook,
    },
    {
        title: 'List Children',
        href: route('children.list', getTenantId()),
        icon: Users,
    },
    {
        title: 'Analysis',
        href: route('analysis.weight', getTenantId()),
        icon: ChartArea,
    },
    {
        title: 'Add Child Event',
        href: route('event.create', getTenantId()),
        icon: NotebookPen,
    },
    {
        title: 'Add Child',
        href: route('children.create', getTenantId()),
        icon: UserRoundPlus,
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard', getTenantId())">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
