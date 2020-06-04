//             别间隔时间(毫秒), 识别服务地址, 认证token
const webAR = new WebAR(1000, 'https://cn1-crs.easyar.com:8443/search', 'YaaDJEr0FloGELPWsj1pd/rtSF1hEvteIy24KsDl83OdSO5CYssOIsUb7dxrvrYLJmDbArTNxRMk4zU42tZFCA==');
// 列出并打开设备上的摄像头

const threeHelper = new ThreeHelper();

let playFlag = false;
let imageFlag = false;
let graphFlag = false;
let modelFlag = false;

function ARStartCamera(){
    const videoSelect = document.querySelector('#videoDevice');
    return webAR.listCamera(videoSelect)
        .then(msg => {
            // // 隐藏"打开摄像头"按钮
            // this.style.display = 'none';
            // videoSelect.style.display = 'inline-block';
            // document.querySelector('#start').style.display = 'inline-block';
            // document.querySelector('#stop').style.display = 'inline-block';
            // videoSelect.onchange = () => {
            //     webAR.openCamera(JSON.parse(videoSelect.value));
            // };
            // 打开摄像头
            // 打开后置摄像头参数： {audio: false, video: {facingMode: {exact: 'environment'}}}

            return webAR.openCamera({audio: false, video: {facingMode: "environment"}})
                .then(msg => {
                    console.info(msg);
                });
        })

}



function ARStart(){
    document.getElementById("scanline").style.display = "block";
    webAR.startRecognize((msg) => {
        document.getElementById("scanline").style.display = "none";
        document.getElementById("loading").style.display = "block";
        console.info(msg);
        let targetId = msg.target.targetId;
        let xmlHttp = new XMLHttpRequest();

        xmlHttp.open("GET","/webar/target/"+targetId,true);
        xmlHttp.send(null);

        xmlHttp.onreadystatechange = function(){
            if (xmlHttp.readyState == 4){

                if (xmlHttp.status == 200){

                    let resp = JSON.parse(xmlHttp.responseText)
                    console.log(resp)
                    if (resp.code == 0){

                        document.querySelector("#title").innerText = resp.data.kname;

                        if (resp.data.model != null){
                            modelFlag = true;
                            const setting = {
                                model: resp.data.model,
                                scale: 0.02,
                                position: [0, 0, 0]
                            };
                            threeHelper.loadObject(setting);
                        }


                        if (resp.data.content != null){
                            document.querySelector(".content").style.display = "block";
                            document.getElementById("text").innerText = resp.data.content;
                        }

                        if (resp.data.video != null){
                            document.querySelector(".movie").style.display = "block";
                            document.getElementById("movie").setAttribute("src",resp.data.video);
                        }

                        if (resp.data.audio != null){
                            document.querySelector(".image").style.display = "block";
                            document.getElementById("image").setAttribute("src",resp.data.audio);
                        }

                        if (resp.data.graph != null){
                            document.querySelector(".graph").style.display = "block";
                            document.getElementById("graph").setAttribute("src",resp.data.graph);
                        }

                        if (!modelFlag){
                            document.getElementById("loading").style.display = "none";

                            if (resp.data.audio != null){
                                imageFlag = true
                                document.getElementById("image").style.display = "block";
                                return true
                            }

                            if (resp.data.video != null){
                                playFlag = true
                                document.getElementById("movie").style.display = "block";
                                return true
                            }

                            if (resp.data.graph != null){
                                graphFlag = true
                                document.getElementById("graph").style.display = "block";
                                return true
                            }



                        }


                        // 可以将 setting 作为meta上传到EasyAR的云识别，使用方法如下
                        // const setting = JSON.parse(window.atob(msg.target.meta));
                        // const setting = {
                        //     video: '//staticfile-cdn.sightp.com/sightp/webar/webardemo-final.mp4',
                        // };
                        // const video = document.createElement('video');
                        // video.setAttribute('controls', 'controls');
                        // video.setAttribute('playsinline', 'playsinline');
                        // video.setAttribute('style', 'position:absolute;top:0;left:0;width:100%;height:100%;z-index:99');
                        // document.body.appendChild(video);
                        // video.src = setting.video;
                        // video.play();
                    }


                }else{
                    // server error
                    console.log(xmlHttp.status);
                    ARStop()
                    ARStart()
                }
            }
        }
    });
}

function ARStop(){
    webAR.stopRecognize();

}



document.querySelector('#openCamera').addEventListener('click', function () {
   ARStartCamera().catch((err) =>{
       alert("没有找到摄像头！");
   });
});
// 开启识别
document.querySelector('#start').addEventListener('click', () => {
    ARStart();
}, false);
// 暂停识别
document.querySelector('#stop').addEventListener('click', () => {
    webAR.stopRecognize();
}, false);
//# sourceMappingURL=app.js.map

document.querySelector(".movie-btn").addEventListener("click",function(){
    if (playFlag){
        document.getElementById("movie").style.display = "none";
    }else{

        document.getElementById("movie").style.display = "block";
    }
    playFlag = !playFlag
},false);


document.querySelector(".image-btn").addEventListener("click",function(){
    if (imageFlag){
        document.getElementById("image").style.display = "none";
    }else{

        document.getElementById("image").style.display = "block";
    }
    imageFlag = !imageFlag
},false);


document.querySelector(".graph-btn").addEventListener("click",function(){
    if (graphFlag){
        document.getElementById("graph").style.display = "none";
    }else{

        document.getElementById("graph").style.display = "block";
    }
    graphFlag = !graphFlag
},false);

if (false){

}else{
    Promise.resolve(1).then(()=>{return ARStartCamera()}).then(()=>{
        document.querySelector(".camera-tip").style.display = "none";
        ARStart();
    }).catch((err) => {
        alert(err)
        if (err.toString().includes("Permission")){
            alert("没有权限");
        }else{
            alert("摄像头未就绪");
        }
    });

}


