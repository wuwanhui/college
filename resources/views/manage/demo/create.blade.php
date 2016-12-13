<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="/js/app.js"></script>
</head>
<body>
<div id="app">
    <div class="content">
        <div class="row">
            <div class="col-md-2  ">
                <form class="form-horizontal" method="POST">
                    <div class="form-group ">
                        <label for="name" class="col-md-3 control-label">名称：</label>

                        <div class="col-md-9">
                            <input type="text" class="form-control"
                                   v-model="demo.name">

                        </div>
                    </div>
                </form>
            </div>

        </div>
        @{{ demo|json }}
    </div>
</div>
<script type="application/javascript">
    new Vue({
        el: '#app',
        props: ['demo11'],
        data: {
            demo: {}
        },
        propsData: {
            msg: {name: 'hello'}
        },
        watch: {},
        methods: {

            setName: function (val) {
                this.$set('demo.name', val);
            }

        }


    });


</script>
</div>
</body>
</html>

