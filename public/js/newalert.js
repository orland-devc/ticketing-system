
class ModernAlert {
    constructor(options = {}) {
        // Default configuration
        this.defaults = {
            title: '',
            text: '',
            icon: null, // 'success', 'error', 'warning', 'info', null
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            showCancelButton: false,
            customClass: '',
            backdrop: true,
            animation: 'fade', // 'fade', 'slide', 'bounce', 'zoom'
            theme: 'light', // 'light', 'dark', 'auto'
            position: 'center', // 'center', 'top', 'top-start', 'top-end', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end'
            width: '32rem',
            padding: '1.25rem',
            timer: null, // milliseconds
            allowOutsideClick: true,
            onConfirm: () => {},
            onCancel: () => {},
            onClose: () => {}
        };
        
        // Merge provided options with defaults
        this.options = { ...this.defaults, ...options };
        
        // Create styles once
        if (!document.getElementById('modern-alert-styles')) {
            this.createStyles();
        }
    }
    
    createStyles() {
        const style = document.createElement('style');
        style.id = 'modern-alert-styles';
        style.textContent = `
            .modern-alert-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
            }
            
            .modern-alert-backdrop.visible {
            opacity: 1;
            }
            
            .modern-alert-container {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            max-width: 90vw;
            max-height: 90vh;
            overflow: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            }
            
            .modern-alert-container.dark {
            background-color: #1f2937;
            color: #e5e7eb;
            }
            
            .modern-alert-icon {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            }
            
            .modern-alert-icon svg {
            width: 4rem;
            height: 4rem;
            }
            
            .modern-alert-icon.success svg {
            color: #10b981;
            }
            
            .modern-alert-icon.error svg {
            color: #ef4444;
            }
            
            .modern-alert-icon.warning svg {
            color: #f59e0b;
            }
            
            .modern-alert-icon.info svg {
            color: #3b82f6;
            }
            
            .modern-alert-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0.5rem;
            padding: 0 1.5rem;
            }
            
            .modern-alert-text {
            text-align: center;
            margin-bottom: 1.5rem;
            padding: 0 1.5rem;
            line-height: 1.5;
            }
            
            .modern-alert-actions {
            display: flex;
            justify-content: center;
            padding: 1rem 1.5rem 1.5rem;
            gap: 0.75rem;
            }
            
            .modern-alert-button {
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 6rem;
            }
            
            .modern-alert-confirm {
            background-color: #3b82f6;
            color: white;
            }
            
            .modern-alert-confirm:hover {
            background-color: #2563eb;
            }
            
            .modern-alert-cancel {
            background-color: #e5e7eb;
            color: #1f2937;
            }
            
            .modern-alert-cancel:hover {
            background-color: #d1d5db;
            }
            
            .dark .modern-alert-cancel {
            background-color: #4b5563;
            color: #e5e7eb;
            }
            
            .dark .modern-alert-cancel:hover {
            background-color: #6b7280;
            }
            
            /* Animation: Fade */
            .modern-alert-container.animation-fade {
            opacity: 0;
            transition: opacity 0.3s ease;
            }
            
            .modern-alert-container.animation-fade.visible {
            opacity: 1;
            }
            
            /* Animation: Slide */
            .modern-alert-container.animation-slide {
            transform: translateY(-50px);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            }
            
            .modern-alert-container.animation-slide.visible {
            transform: translateY(0);
            opacity: 1;
            }
            
            /* Animation: Bounce */
            .modern-alert-container.animation-bounce {
            transform: scale(0.8);
            opacity: 0;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
            }
            
            .modern-alert-container.animation-bounce.visible {
            transform: scale(1);
            opacity: 1;
            }
            
            /* Animation: Zoom */
            .modern-alert-container.animation-zoom {
            transform: scale(1.2);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            }
            
            .modern-alert-container.animation-zoom.visible {
            transform: scale(1);
            opacity: 1;
            }
            
            /* Positions */
            .modern-alert-container.position-center {
            margin: auto;
            }
            
            .modern-alert-container.position-top {
            margin: 5vh auto auto auto;
            }
            
            .modern-alert-container.position-top-start {
            margin: 5vh auto auto 5vw;
            }
            
            .modern-alert-container.position-top-end {
            margin: 5vh 5vw auto auto;
            }
            
            .modern-alert-container.position-bottom {
            margin: auto auto 5vh auto;
            }
            
            .modern-alert-container.position-bottom-start {
            margin: auto auto 5vh 5vw;
            }
            
            .modern-alert-container.position-bottom-end {
            margin: auto 5vw 5vh auto;
            }
        `;
        document.head.appendChild(style);
    }
    
    getIconSvg() {
        const icons = {
            success: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>`,
            error: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>`,
            warning: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>`,
            info: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>`
        };
        
        return this.options.icon ? icons[this.options.icon] : '';
    }
    
    show() {
        // Create backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modern-alert-backdrop';
        if (!this.options.backdrop) {
            backdrop.style.backgroundColor = 'transparent';
        }
        
        // Create container with correct theme, width, and position
        const container = document.createElement('div');
        container.className = `modern-alert-container animation-${this.options.animation} position-${this.options.position} ${this.options.customClass}`;
        container.style.width = this.options.width;
        container.style.padding = this.options.padding;
        
        if (this.options.theme === 'dark' || (this.options.theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            container.classList.add('dark');
        }
        
        // Create content
        let html = '';
        
        // Add icon if specified
        if (this.options.icon) {
            html += `<div class="modern-alert-icon ${this.options.icon}">${this.getIconSvg()}</div>`;
        }
        
        // Add title if specified
        if (this.options.title) {
            html += `<div class="modern-alert-title">${this.options.title}</div>`;
        }
        
        // Add text if specified
        if (this.options.text) {
            html += `<div class="modern-alert-text">${this.options.text}</div>`;
        }
        
        // Add action buttons
        html += `<div class="modern-alert-actions">`;
        
        if (this.options.showCancelButton) {
            html += `<button class="modern-alert-button modern-alert-cancel">${this.options.cancelButtonText}</button>`;
        }
        
        html += `<button class="modern-alert-button modern-alert-confirm">${this.options.confirmButtonText}</button>`;
        html += `</div>`;
        
        container.innerHTML = html;
        backdrop.appendChild(container);
        document.body.appendChild(backdrop);
        
        // Set up event listeners
        const confirmButton = container.querySelector('.modern-alert-confirm');
        const cancelButton = container.querySelector('.modern-alert-cancel');
        
        const close = (confirmed = true) => {
            // Animate out
            container.classList.remove('visible');
            backdrop.classList.remove('visible');
            
            // Remove after animation completes
            setTimeout(() => {
            document.body.removeChild(backdrop);
            if (confirmed) {
                this.options.onConfirm();
            } else {
                this.options.onCancel();
            }
            this.options.onClose();
            }, 300);
        };
        
        // Handle confirm button click
        confirmButton.addEventListener('click', () => close(true));
        
        // Handle cancel button click if shown
        if (cancelButton) {
            cancelButton.addEventListener('click', () => close(false));
        }
        
        // Handle outside click if allowed
        if (this.options.allowOutsideClick) {
            backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                close(false);
            }
            });
        }
        
        // Handle ESC key
        const escHandler = (e) => {
            if (e.key === 'Escape') {
            close(false);
            document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
        
        // Set timer if specified
        if (this.options.timer) {
            setTimeout(() => {
            close(true);
            }, this.options.timer);
        }
        
        // Trigger animation
        setTimeout(() => {
            backdrop.classList.add('visible');
            container.classList.add('visible');
        }, 10);
        
        // Return promise
        return new Promise((resolve) => {
            this.options.onConfirm = () => resolve(true);
            this.options.onCancel = () => resolve(false);
        });
    }
        
        // Static helper methods for common use cases
    static success(options) {
        return new ModernAlert({
            icon: 'success',
            ...options
        }).show();
    }
        
    static error(options) {
        return new ModernAlert({
            icon: 'error',
            ...options
        }).show();
    }
        
    static warning(options) {
        return new ModernAlert({
            icon: 'warning',
            ...options
        }).show();
    }
    
    static info(options) {
        return new ModernAlert({
            icon: 'info',
            ...options
        }).show();
    }
    
    static confirm(options) {
        return new ModernAlert({
            icon: 'warning',
            showCancelButton: true,
            ...options
        }).show();
    }
        
}

  
