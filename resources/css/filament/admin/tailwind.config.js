import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Clusters/Account/**/*.php',
        './resources/views/filament/clusters/account/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
            './vendor/awcodes/filament-table-repeater/resources/**/*.blade.php',
    ],
}
