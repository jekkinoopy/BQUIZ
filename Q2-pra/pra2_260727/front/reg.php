<fieldset>
    <legend>會員註冊</legend>

    <table>
        <tr style="color:red;">
            <td>*請設定您要註冊的帳號及密碼（最長12個字元）</td>
        </tr>
        <tr>
            <td>Step1:登入帳號</td>
            <td><input type="text" id="acc" name="acc"></td>
        </tr>
        <tr>
            <td>Step2:登入密碼</td>
            <td><input type="password" ></td>	</tr>
        <tr>
            <td>Step3:再次確認密碼</td>
            <td><input type="password"></td>	</tr>
        <tr>
            <td>Step4:信箱（忘記密碼時使用）</td>
            <td><input type="email"></td>	
        </tr>
        <tr>
            <td>
                <button type="button">註冊</button>
                <button type="button" onclick="$('#acc', '#password').val('')">清除</button>
            </td>   
        </tr>
    </table>
                
</fieldset>