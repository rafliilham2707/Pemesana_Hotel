import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Toast store for global notifications
document.addEventListener('alpine:init', () => {
    Alpine.store('toasts', {
        items: [],
        add(toast) {
            const id = Date.now() + Math.random().toString(36).substring(2, 9);
            const item = {
                id,
                title: toast.title || '',
                description: toast.description || '',
                variant: toast.variant || 'default', // default, destructive, success, warning
                timeout: toast.timeout ?? 5000,
            };
            this.items.push(item);
            if (item.timeout > 0) {
                setTimeout(() => {
                    this.remove(id);
                }, item.timeout);
            }
            return id;
        },
        remove(id) {
            this.items = this.items.filter(t => t.id !== id);
        }
    });
});

Alpine.start();
