import Alpine from 'alpinejs';
import {
    ArrowUpDown,
    ArrowRightLeft,
    BadgeCheck,
    Bell,
    Briefcase,
    BriefcaseBusiness,
    Building2,
    CalendarDays,
    ChartBar,
    CircleCheck,
    ChevronDown,
    ClipboardList,
    Cog,
    LayoutDashboard,
    ListTodo,
    MoonStar,
    PanelLeftOpen,
    MessagesSquare,
    Pencil,
    Search,
    Sparkles,
    Trash,
    UserPlus,
    UsersRound,
    X,
    createIcons,
} from 'lucide';

window.Alpine = Alpine;
window.loadCharts = () => import('chart.js/auto').then((module) => module.default);
window.loadSortable = () => import('sortablejs').then((module) => module.default);

const iconSet = {
    'arrow-up-down': ArrowUpDown,
    'arrows-right-left': ArrowRightLeft,
    'badge-check': BadgeCheck,
    bell: Bell,
    briefcase: Briefcase,
    'briefcase-business': BriefcaseBusiness,
    'building-2': Building2,
    'calendar-days': CalendarDays,
    'chart-bar': ChartBar,
    'chat-bubble-left-right': MessagesSquare,
    'check-circle': CircleCheck,
    'chevron-down': ChevronDown,
    'clipboard-document-list': ClipboardList,
    'cog-6-tooth': Cog,
    'layout-dashboard': LayoutDashboard,
    'list-todo': ListTodo,
    'moon-star': MoonStar,
    'panel-left-open': PanelLeftOpen,
    'pencil-square': Pencil,
    search: Search,
    sparkles: Sparkles,
    trash: Trash,
    'user-plus': UserPlus,
    'users-round': UsersRound,
    x: X,
};

window.applyTheme = (theme) => {
    const resolved = theme === 'system'
        ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
        : theme;

    document.documentElement.classList.toggle('dark', resolved === 'dark');
    localStorage.setItem('crm-theme', resolved);
};

window.refreshIcons = () => createIcons({ icons: iconSet });

document.addEventListener('alpine:init', () => {
    Alpine.data('appShell', (defaultTheme = 'light') => ({
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('crm-sidebar') === 'collapsed',
        init() {
            window.applyTheme(localStorage.getItem('crm-theme') || defaultTheme);
            this.$nextTick(() => window.refreshIcons());
        },
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('crm-sidebar', this.sidebarCollapsed ? 'collapsed' : 'expanded');
        },
    }));
});

document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('crm-theme');
    if (savedTheme) {
        window.applyTheme(savedTheme);
    }

    window.refreshIcons();
});

document.addEventListener('livewire:navigated', window.refreshIcons);
document.addEventListener('livewire:initialized', window.refreshIcons);

Alpine.start();
