# Claude 禁止事項（血淚教訓）

- **禁止在 sandbox 執行任何 git 指令**（`git add`、`git status`、`git commit` 等），會留下 `index.lock` 卡住用戶本機 git
- **改完檔案必須主動 present_files**，不等用戶開口
- **改完檔案必須主動給 commit 指令**，不等用戶開口
- commit 格式：`git add .` 換行 `git commit -m "type: 重點"`，禁止用 `&&`
- 詳細 git 規則見 `git-commit-required.md`
