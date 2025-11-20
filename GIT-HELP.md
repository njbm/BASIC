1. Basic Commits with Emoji

Open emoji picker on Windows: Win + .

# Stage changes
git add .

# Commit with a single emoji
git commit -m "✨ add send-message media feature"

# Common emoji examples:
# ✨ New feature / enhancement
# 🐛 Bug fix
# 🔥 Remove code / refactor
# 🖼️ Image / media
# ⚡ Performance improvements
# 🔒 Security
# 📝 Documentation
# 🚀 Deployment / release
# ♻️ Refactor
# ✅ Tests
# 🔧 Tooling / config

2. Amending Last Commit
# Inline amend (no editor)
git commit --amend -m "🖼️ working on send-message media --image"

# Amend using editor
git commit --amend
# Edit commit message, save and exit

# If already pushed, force update
git push --force

3. Undo Last Commit
# Keep changes staged
git reset --soft HEAD~1
git commit -m "🖼️ correct commit message"

4. Push Commits
# Normal push
git push

# Force push (only if you amended/reset commits)
git push --force

5. Useful Git Shortcuts
# Check status
git status

# Check logs in concise graph
git log --oneline --graph --decorate

# Unstage a file
git restore --staged <file>

# Discard local changes
git restore <file>

6. Windows Emoji Tips
- Press Win + . (Windows key + period) → opens emoji picker
- Select emoji directly in terminal or editor
- Avoid pasting multiple emojis from web (can cause garbled characters like â)
- One emoji per commit is enough for clarity

7. Recommended Git Workflow
# Stage changes
git add .

# Commit with appropriate emoji
git commit -m "✨ add new media feature"

# Push to branch
git push origin feature/send-message-media

# If commit message needs fixing
git commit --amend -m "🖼️ working on send-message media --image"
git push --force