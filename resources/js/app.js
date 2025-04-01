//resources/js/app.js
import './bootstrap';

import Alpine from 'alpinejs';

import React from 'react';
import ReactDOM from 'react-dom/client';
import ExampleComponent from './components/ExampleComponent';
import { createIcons, icons } from 'lucide';

document.addEventListener("DOMContentLoaded", () => {
    createIcons();
});

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('react-root');
    if (rootElement) {
        // Use React.createElement instead of JSX
        ReactDOM.createRoot(rootElement).render(
            React.createElement(
                React.StrictMode, 
                null, 
                React.createElement(ExampleComponent)
            )
        );
    }
});