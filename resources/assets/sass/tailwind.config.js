const defaultConfig = require('tailwindcss/defaultConfig');

module.exports = {
    theme: {
        fontFamily: {
            display: ['Nunito', 'sans-serif'],
            body: ['Graphik', 'sans-serif'],
        },
    },
    variants: {
        backgroundColor: [...defaultConfig.variants.backgroundColor, 'group-hover'],
        display: [...defaultConfig.variants.display, 'group-hover'],
        visibility: [defaultConfig.variants.visibility, 'hover'],
    },
    plugins: []
}
