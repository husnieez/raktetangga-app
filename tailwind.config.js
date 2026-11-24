/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Livewire/**/*.php",
        "./index.html",
    ],
    theme: {
        extend: {
            colors: {
                canvas: '#F6F1E7',
                cardstock: '#FFFDF9',
                espresso: '#2C241E',
                clay: '#6E6259',
                terracotta: {
                    DEFAULT: '#D95D39',
                    hover: '#C24D2B',
                    active: '#A94022',
                },
                sage: {
                    DEFAULT: '#3A6B56',
                    light: '#EAF2EE',
                    dark: '#2E5544',
                },
                ochre: {
                    DEFAULT: '#E09F3E',
                    light: '#FDF5E8',
                    dark: '#BF8228',
                },
                manila: {
                    DEFAULT: '#EFE7D8',
                    dark: '#E2D5BF',
                },
                rule: '#D8CFC0',
            },
            fontFamily: {
                serif: ['Fraunces', 'Lora', 'Georgia', 'serif'],
                sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
            },
            boxShadow: {
                'hard-xs': '2px 2px 0px #2C241E',
                'hard-sm': '3px 3px 0px #2C241E',
                'hard': '4px 4px 0px #2C241E',
                'hard-md': '5px 5px 0px #2C241E',
                'hard-lg': '7px 7px 0px #2C241E',
                'hard-terracotta': '4px 4px 0px #A94022',
                'hard-sage': '3px 3px 0px #2E5544',
            },
            borderWidth: {
                '1.5': '1.5px',
            },
            backgroundImage: {
                'lined-paper': 'repeating-linear-gradient(to bottom, transparent, transparent 31px, #D8CFC0 31px, #D8CFC0 32px)',
                'grid-paper': 'radial-gradient(#6E6259 0.75px, transparent 0.75px)',
            },
        },
    },
    plugins: [],
}

