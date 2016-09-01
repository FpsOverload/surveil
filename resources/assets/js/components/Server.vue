<template>
    <div class="server-banner">
        <header :style="{ backgroundImage: 'url(' + image + ')' }">
            <div class="titles flex flex-align-center">
                <span class="status-button offline">Offline</span>
                <span class="game-logo">
                    <svg width="100" height="100">
                        <use xlink:href="#arma3-logo" />
                    </svg>
                </span>
                <h3 class="server-name">My Server Name Goes Here!</h3>
            </div>
        </header>
        <div class="server-banner-content flex flex-space-btwn flex-align-center">
            <div class="status">
                <a class="connect" href="#">arma3.fpsoverload.com</a>
            </div>
            <div class="overview">
                <span data-title="Players">34/64</span>
                <span data-title="Map">Tanoa</span>
                <a class="btn btn-small" href="#">+Info</a>
                <a class="btn btn-small" href="#">Stats</a>
            </div>
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
