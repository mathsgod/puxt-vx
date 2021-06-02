<div id="div1">
    vuesax
    <vs-pagination :total="40" v-model="currentx"></vs-pagination>
</div>


<script>
    new Vue({
        el: "#div1",
        data: () => ({
            currentx: 14

        })
    });
</script>