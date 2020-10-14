const defaultConfig = require('tailwindcss/defaultConfig');

module.exports = {
    theme: {
        fontFamily: {
            display: ['Nunito', 'sans-serif'],
            body: ['Graphik', 'sans-serif'],
        },
    },
    variants: {
        visibility: [defaultConfig.variants.visibility, 'hover'],
    },
    plugins: []
}
