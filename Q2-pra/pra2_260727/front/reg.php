<fieldset style="width: 50%;margin:auto ">
    <legend>會員註冊</legend>

    <div style="color:red;">
        *請設定您要註冊的帳號及密碼(最長12個字元)
    </div>
    <table>
        <tr>
            <td>Step1:登入帳號</td>
            <td><input type="text" id="acc" name="acc"></td>
        </tr>
        <tr>
            <td>Step2:登入密碼</td>
            <td><input type="password" id="pw" name="pw" ></td>	</tr>
        <tr>
            <td>Step3:再次確認密碼</td>
            <td><input type="password" id="pw2" name="pw2"></td>	</tr>
        <tr>
            <td>Step4:信箱(忘記密碼時使用)</td>
            <td><input type="text" id="email" name="email"></td>	
        </tr>
        <tr>
            <td>
                <button type="button">註冊</button>
                <button type="button" 
                        onclick="$('#acc, #pw,#pw2,#email').val('')">清除
                </button>
            </td>   
            <td></td>
        </tr>
    </table>
                
</fieldset>