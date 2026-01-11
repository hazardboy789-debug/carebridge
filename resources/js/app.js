import './bootstrap';
import 'flowbite';

// Remove any duplicate Alpine imports
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

import Swal from 'sweetalert2';

// Real-time notification toast listener (requires Echo/pusher + Vite env vars)
try {
	const userId = window?.Laravel?.userId;
	if (userId && window.Echo) {
		window.Echo.private(`App.Models.User.${userId}`).notification((notification) => {
			const title = notification.title || notification.type || 'Notification';
			const body = notification.body || notification.data?.body || '';

			Swal.fire({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 5000,
				icon: 'info',
				title: title,
				text: body,
			});

			if (window.livewire) {
				window.livewire.emit('notificationsUpdated');
			}
		});
	}
} catch (e) {
	console.warn('Notification listener not initialized', e);
}