<?php
    require_once('../config.php');
?>

<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'cl'){
        $id = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from chat inner join user on user.id_user=chat.id_u1 where id_u2 = '$id' and chat.status = 1 order by chat.created desc");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        if($row){$last = $row[0]['id_chat'];}else{$last = 0;}
        foreach($row as $r){
            $sql1 = mysqli_query($conn,"SELECT * from isichat where who = 'u1' and seen = 0");
            $n = mysqli_num_rows($sql1);
            ?>
            <div class="p-2 mb-2 row chat-bubble" onclick="openChat(<?php echo $r['id_chat']?>,1)" style="margin:0;align-items:center;position:relative">
                <?php if($n){echo '<div class="new-msg">'.$n.'</div>';}?>
                <div class="col-4">
                    <div class="dp">
                        <div>
                            <img src="<?php echo DP_DIR.$r['dp'].'.png'?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-8" style="padding-left: 0;">
                    <h5><?php echo $r['nama'];?></h5>
                </div>
            </div>
            <?php
        } echo '<input type="text" id="lastNewCh" value="'.$last.'" hidden>';
        ?>
        <?php
    }

    if(isset($_POST['mode']) && $_POST['mode'] == 'clr'){
        $id = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from chat inner join user on user.id_user=chat.id_u1 where id_u2 = '$id' and chat.status = 0 order by chat.closed");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        ?>
            <div style="position: relative;text-align:center;padding:10px;">
                <h5 style="color:#dcdcdc;">Riwayat Chat</h5>
                <div style="position: absolute;top:20px;right:0;left:0;height:2pt;background:linear-gradient(90deg, rgba(220,220,220,1) 0%, rgba(220,220,220,1) 23%, rgba(255,255,255,0) 24%, rgba(255,255,255,0) 75%, rgba(220,220,220,1) 76%, rgba(220,220,220,1) 100%);"></div>
            </div>
        <?php
        foreach($row as $r){
            ?>
            <div class="p-2 mb-2 row chat-bubble" onclick="openChat(<?php echo $r['id_chat']?>,0)" style="margin:0;align-items:center;position:relative">
                
                <div class="col-4">
                    <div class="dp">
                        <div>
                            <img src="<?php echo DP_DIR.$r['dp'].'.png'?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-8" style="padding-left: 0;">
                    <h5><?php echo $r['nama'];?></h5>
                </div>
            </div>
            <?php
        }
        ?>
        <?php
    }

    if(isset($_POST['mode']) && $_POST['mode'] == 'cek'){
        $id = $_SESSION['user']['id_user'];
        $lastChatId = $_POST['lcid'];
        $openedChatid = $_POST['opch'];
        $sql = mysqli_query($conn,"SELECT * from chat where id_u2 = '$id' and id_chat > '$lastChatId'");
        if(mysqli_num_rows($sql)){
            $nc = 1; 
        }else{
            $nc = 0;
        }
        $sql = mysqli_query($conn,"SELECT * from isichat where who = 'u1' and seen = 0");
        $n = mysqli_num_rows($sql);
        if(mysqli_num_rows($sql)){
            $nm = 1; 
        }else{
            $nm = 0;
        }
        $sql = mysqli_query($conn,"SELECT * from chat inner join isichat on chat.id_chat=isichat.id_chat where chat.id_chat ='$openedChatid' and who = 'u1' and seen = 0");
        $n = mysqli_num_rows($sql);
        if(mysqli_num_rows($sql)){
            $nmc = 1; 
        }else{
            $nmc = 0;
        }
        $myObj = new \stdClass();
        $myObj->nc = $nc;
        $myObj->nm = $nm;
        $myObj->nmc = $nmc;

        $myJSON = json_encode($myObj);

        echo $myJSON;
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'cek2'){
        $id_chat = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * from isichat where id_chat = '$id_chat' and who='u2' and seen = 0");
        if(mysqli_num_rows($sql)==0){
            echo 1;
        }
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'oc'){
        $id_chat = $_POST['id'];
        $id2 = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from chat where id_chat ='$id_chat'");
        $chatinfo = mysqli_fetch_assoc($sql);
        if(mysqli_num_rows($sql)!=0){
            $id1 = $chatinfo['id_u1'];
            $sql = mysqli_query($conn,"SELECT * from user where id_user = '$id1'");
            $user = mysqli_fetch_assoc($sql);
            if($chatinfo['status'] == 1){
                ?>
                <div class="card card-nb">
                    <div class="chat-wrap">
                        <div class="chat-header row" style="margin:0;display:flex;align-items:center;justify-content: center;">
                            
                            <div class="col-2">
                                <div class="dp" style="width:50px">
                                    <div>
                                        <img src="<?php echo DP_DIR.$user['dp'].'.png'?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4><?php echo $user['nama'];?></h4>
                            </div>
                            <div class="col-4">
                                <div class="btn-chat" style="font-size: 8pt;" onclick="closeC('<?php echo $id_chat?>')">
                                    Akhiri Sesi Chat
                                </div>
                            </div>
                        </div>
                        <div class="chat-body">
                            <?php
                                $sql = mysqli_query($conn,"SELECT * FROM isichat where id_chat='$id_chat' order by created");
                                $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                                foreach($row as $r){
                                    $time = date('h.i',strtotime($r['created']));
                                    ?>
                                    <div class="<?php if($r['who']=='u2'){echo'chat-sent';}else{echo 'chat-rec';}?>">
                                        <div><?php echo $r['isi'];?></div>
                                        <span class="isi-detail <?php if($r['who']=='u2' && $r['seen']){echo 'seen';}?>"> <?php if($r['who']=='u2' && $r['seen']){echo 'seen';}?> <?php echo $time;?></span>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="chat-control">
                            <div class="row" style="margin:0;height:100%;display:flex;align-items:center;justify-content: center;">
                                <div class="col-2" style="text-align: center;padding:0">
                                    <form enctype="multipart/form-data"><input type="file" id="img-file" style="display: none;" accept="image/*"></form>
                                    <input type="text" id="id-ch" value="<?php echo $chatinfo['id_chat'];?>" hidden>
                                    <label for="img-file">
                                        <div id="btn-img" class="chat-btn">
                                            <i class="fas fa-image "></i>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-8" style="height: 100%;padding:0;overflow-y:scroll;">
                                    <div id="msg-content" contenteditable="true"></div>
                                </div>
                                <div class="col-2" style="text-align: center;padding:0">
                                    <div id="btn-send" class="chat-btn" onclick="send(<?php echo $chatinfo['id_chat'];?>)"> 
                                        <i class="fas fa-paper-plane "></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#img-file').change(function(){
                        var name = $('#img-file')[0].files[0].name;
                        var id = $('#id-ch').val();
                        var fd = new FormData();
                        var ext = name.split('.').pop().toLowerCase();
                        if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                            alert("Invalid Image File");
                        }
                        else{
                            var oFReader = new FileReader();
                            oFReader.readAsDataURL($('#img-file')[0].files[0]);
                            var f = $('#img-file')[0].files[0];
                            var fsize = f.size||f.fileSize;
                            if(fsize > 10000000){
                                alert("Ukuran File Terlalu Besar");
                            }
                            else
                            {
                                fd.append("img", $('#img-file')[0].files[0]);
                                fd.append("mode", 'sendImg');
                                fd.append("id", id);
                                $('.kiri-load').css('display','block');
                                $.ajax({
                                    url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
                                    method:"POST",
                                    data:fd,
                                    processData: false,
                                    contentType: false,
                                    success:function(data)
                                    {
                                        $('.kiri-load').css('display','none');
                                        $('.chat-body').append(data);
                                        $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
                                    },error:function(data){
                                        console.log('ERROR NIH');
                                    }
                                });
                            }
                        }
                        
                    })
                    
                    document.querySelector("div[contenteditable]").addEventListener("paste", function(e) {
                        e.preventDefault();
                        var text = e.clipboardData.getData("text/plain");
                        document.execCommand("insertHTML", false, text);
                    });
                </script>
                <?php
                $sql = mysqli_query($conn,"UPDATE isichat set seen=1 where id_chat='$id_chat' and who = 'u1'");
            }else{
                ?>
                <div class="card card-nb">
                    <div class="chat-wrap">
                        <div class="chat-header row" style="margin:0;display:flex;align-items:center;justify-content: center;">
                            <div class="col-2">
                                
                            </div>
                            <div class="col-2">
                                <div class="dp" style="width:50px">
                                    <div>
                                        <img src="<?php echo DP_DIR.$user['dp'].'.png'?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <h4><?php echo $user['nama'];?></h4>
                            </div>
                        </div>
                        <div class="chat-body">
                            <?php
                                $sql = mysqli_query($conn,"SELECT * FROM isichat where id_chat='$id_chat' order by created");
                                $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                                foreach($row as $r){
                                    $time = date('h.i',strtotime($r['created']));
                                    ?>
                                    <div class="<?php if($r['who']=='u2'){echo'chat-sent';}else{echo 'chat-rec';}?>">
                                        <div><?php echo $r['isi'];?></div>
                                        <span class="isi-detail <?php if($r['who']=='u2' && $r['seen']){echo 'seen';}?>"> <?php if($r['who']=='u2' && $r['seen']){echo 'seen';}?> <?php echo $time;?></span>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="chat-control">
                            <h4 style="margin-top:10px;text-align: center;"><i class="fas fa-star mr-3" style="color:gold"></i><?php if($chatinfo['rating']){echo $chatinfo['rating'];}else{echo 'Belum ada Rating';}?></h4>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        
    }   
    if(isset($_POST['mode']) && $_POST['mode'] == 'cc'){
        $id_chat = $_POST['id'];
        $sql = mysqli_query($conn,"UPDATE chat set status=0,closed=now() where id_chat='$id_chat'");
        $id = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"UPDATE ahli set avail=1 where id_user='$id'");
    }
?>

<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'send'){
        $id_chat = $_POST['id'];
        $isi = $_POST['isi'];
        $created = date('h.i',time());
        $sql = mysqli_query($conn,"INSERT INTO isichat (id_chat,who,isi,seen,created) VALUES('$id_chat','u2','$isi',0,now())");
        ?>
        <div class="chat-sent">
            <div><?php echo $isi;?></div>
            <span class="isi-detail"><?php echo $created;?></span>
        </div>
        <?php 
    }

    if(isset($_POST['mode']) && $_POST['mode'] == 'rec'){
        $id_chat = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * FROM isichat where id_chat ='$id_chat' and who='u1' and seen = '0'");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
            
        $created = date('h.i',strtotime($r['created']));
        ?>
        <div class="chat-rec">
            <div><?php echo $r['isi'];?></div>
            <span class="isi-detail"><?php echo $created;?></span>
        </div>
        <?php
        }
        $sql = mysqli_query($conn,"UPDATE isichat set seen=1 where id_chat='$id_chat' and who = 'u1'");
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'sendImg'){
        $id_chat = $_POST['id'];
        $img = explode('.', $_FILES["img"]["name"]);
        $ext = end($img);
        $imgname = $id_chat.'_'.date('Ymdhi',time()).'.'.$ext;
        $location = ROOT_PATH.'/ass/img/chat/'.$imgname;
        move_uploaded_file($_FILES["img"]["tmp_name"], $location);
        $img = '<img src="'.CHATIMG_DIR.$imgname.'" onclick="showImg(this)" style="width:100%;cursor:pointer;">';
        $created = date('h.i',time());
        $sql = mysqli_query($conn,"INSERT INTO isichat (id_chat,who,isi,seen,created) VALUES('$id_chat','u2','$img',0,now())");
        ?>
        <div class="chat-sent">
            <div><?php echo $img;?></div>
            <span class="isi-detail"><?php echo $created;?></span>
        </div>
        <?php 
    }

    if(isset($_POST['mode']) && $_POST['mode'] == 'actMod'){
        $s = $_POST['s'];
        $id = $_SESSION['user']['id_user'];
        echo $s.$id;
        $sql = mysqli_query($conn,"UPDATE ahli set avail='$s' where id_user='$id'");
    }
?>
