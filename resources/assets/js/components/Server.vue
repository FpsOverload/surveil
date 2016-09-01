<template>
    <div class="server-banner">
        <header :style="{ backgroundImage: 'url(' + image + ')' }">
            <div class="titles">
                <span class="game-logo">
                    <svg width="100" height="100">
                        <use xlink:href="#arma3-logo" />
                    </svg>
                </span>
                <h3 class="server-name">My Server Name Goes Here!</h3>
            </div>
        </header>
        <div class="server-banner-content">

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            image: '',
        },
        ready() {
            console.log('Component ready.')
        }
    }
</script>
