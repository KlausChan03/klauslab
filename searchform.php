<el-form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
    <el-form-item>
        <el-input type="text" value="" name="s" id="s" placeholder="请输入搜索内容">
            <el-button @click="searchByButton" slot="append" icon="el-icon-search"></el-button>
        </el-input>
    </el-form-item>
    <!-- <el-form-item>
        <el-button type="primary" @click="onSubmit">搜索</el-button>
        <el-button type="primary" id="searchsubmit" value="Search" >搜索</el-button>
    </el-form-item> -->
</el-form>
<script>
    let searchMain = new Vue({
        el: '#searchform',
        methods: {
            searchByButton() {
                console.log("kkjkj")
                debugger

                // var inpEle = document.getElementById('search-button')
                // var event = document.createEvent('Event')
                // event.initEvent('keydown', true, false) //注意这块触发的是keydown事件，在awx的ui源码中bind监控的是keypress事件，所以这块要改成keypress
                // event = Object.assign(event, {
                //     ctrlKey: false,
                //     metaKey: false,
                //     altKey: false,
                //     which: 13,
                //     keyCode: 13,
                //     key: 'Enter',
                //     code: 'Enter'
                // })
                // inpEle.focus()
                // inpEle.dispatchEvent(event)
            }
        },
    })
</script>