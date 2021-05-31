<div id="div1">
    <div class="table-responsive">
        <table class="table table-striped table-borderless">
            <thead class="thead-light">
                <tr>
                    <th>Module</th>
                    <th>Read</th>
                    <th>Write</th>
                    <th>Create</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="m in Module">
                    <td v-text="m"></td>
                    <td>
                        <el-checkbox></el-checkbox>
                    </td>
                    <td>
                        <el-checkbox></el-checkbox>
                    </td>
                    <td>
                        <el-checkbox></el-checkbox>
                    </td>
                    <td>
                        <el-checkbox></el-checkbox>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<script>
    new Vue({
        el: "#div1",
        data() {
            return {
                usergroup_id: null,
                UserGroup: [],
                Module: []
            }
        },
        async created() {
            this.UserGroup = (await this.$vx.get("ACL/all?_method=getUserGroup")).data;
            this.Module = (await this.$vx.get("ACL/all?_method=getModule")).data;
            console.log(this.Module);
        }
    });
</script>