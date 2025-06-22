/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    screens:{
      sm: '480px',
      md:'768px',
      lg:'976px',
      xl: '1440px',
    },
    extend: {
      colors:{
        sePrimary : '#201B50',
        seSecondary: '#FAB417',
        seThird: '#ffc745',
        red: '#ef4444',

        blue: '#2468d2',
        blue2: '#C5D8FD',
        blue3: '#468FEA',
        blue4: '#3b7add',
        blue5: '#6697e5',

        yellow: '#f3a71a',

        gray: "#616161",
        gray2: "#454545",
        gray3: "#cdcdcd",
        gray4: "#e2e2e2",
        gray5: "#dadcdc",

        green: "#31a858",
        green2: "#b4e9c5",
        green3: "#73d693",

        beige: "#f0a222",
        beige2: "#fbd1a2",

        pink: "#ffc8dd",
        pink2: "#ff5d9b",

        black: "#161616ff",

        red: "#fb6a5e",

      },
      fontFamily: {
        'body': [
      'Inter', 
      'ui-sans-serif', 
      'system-ui', 
      '-apple-system', 
      'system-ui', 
      'Segoe UI', 
      'Roboto', 
      'Helvetica Neue', 
      'Arial', 
      'Noto Sans', 
      'sans-serif', 
      'Apple Color Emoji', 
      'Segoe UI Emoji', 
      'Segoe UI Symbol', 
      'Noto Color Emoji'
    ],
    'sans': [
      'Inter', 
      'ui-sans-serif', 
      'system-ui', 
      '-apple-system', 
      'system-ui', 
      'Segoe UI', 
      'Roboto', 
      'Helvetica Neue', 
      'Arial', 
      'Noto Sans', 
      'sans-serif', 
      'Apple Color Emoji', 
      'Segoe UI Emoji', 
      'Segoe UI Symbol', 
      'Noto Color Emoji'
    ]
      }
    },
  },
  plugins: [
    require('flowbite/plugin'),
  ],
    


}


