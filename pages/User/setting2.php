<div id="div1">
    <el-row :gutter="12">
        <el-col :md="6">
            <vx-nav v-model="selected" pills class="flex-column nav-left">
                <vx-nav-item index="itema" icon="fa fa-user">ItemA</vx-nav-item>
                <vx-nav-item index="itemb">Item B</vx-nav-item>
            </vx-nav>

        </el-col>


        <el-col :lg="18">
            <div v-if="selected=='itema'">
                itema
            </div>
            <div v-if="selected=='itemb'">
                itemb
            </div>
        </el-col>
    </el-row>


</div>

<script>
    new Vue({
        el: "#div1",
        data() {
            return {
                selected: "itema"
            }
        },
        watch: {
            selected() {
                console.log("selecte");
            }
        }

    })
</script>