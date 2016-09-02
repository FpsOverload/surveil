<template>
    <div class="server-banner">
        <header :style="{ backgroundImage: 'url(' + data.image + ')' }">
            <div class="titles flex flex-align-center">
                <span class="status-button" :class="data.online ? 'online' : 'offline'">{{ data.online ? 'Online' : 'Offline' }}</span>
                <span class="game-logo">
                    <svg width="100" height="100">
                        <use xlink:href="#{{ data.game }}-logo" />
                    </svg>
                </span>
                <h3 class="server-name">My Server Name Goes Here!</h3>
            </div>
        </header>
        <div class="server-banner-content flex flex-space-btwn flex-align-center">
            <div class="overview">
                <a class="multi-line connect" href="#" data-title="Connect">{{ data.host }}<span class="port">:{{ data.port }}</span></a>
            </div>
            <div class="overview flex flex-align-center">
                <span class="multi-line" data-title="Players">34/64</span>
                <span class="multi-line" data-title="Map">Tanoa</span>
                <a class="btn btn-small" href="#">+Info</a>
                <a class="btn btn-small" href="#">Stats</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            data: {},
        },
        ready() {
            console.log('Component ready.')
        }
    }
</script>
