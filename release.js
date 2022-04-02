/** release.js **/
const process = require('process')
const path = require('path')
const fs = require('fs')
const semver = require('semver')
const inquirer = require('inquirer')
const execa = require('execa')
const chalk = require('chalk')

// PS: 调试的时候把该地址改成本地 npm 私服
const NPM_DEFAULT_REGISTRY = 'https://registry.npmjs.org'

const root = process.cwd()
// package.json 文件内容
const rootPkgInfo = require(path.resolve(root, 'package.json'))
const currentVersion = rootPkgInfo.version
const semverReleaseType = ['patch', 'minor', 'major', 'prepatch', 'preminor', 'premajor', 'prerelease']

/**
 * 打印步骤
 */
const step = (msg) => console.log(chalk.cyan(msg))

/**
 * 询问并更新版本号
 */
async function updateVersion() {
  step('\n更新版本号')
  // inquirer 交互式询问下一个版本号
  const { targetVersion } = await inquirer.prompt([
    {
      type: 'list',
      name: 'targetVersion',
      message: '选择你想要发布的版本: ',
      choices: semverReleaseType
        .map(release => semver.inc(currentVersion, release, 'beta')) // semver.inc 方法递增版本号
        .map(v => ({ value: v, title: v }))
    }
  ])

  // 更新版本号并写入 package.json 文件中
  rootPkgInfo.version = targetVersion
  fs.writeFileSync(path.resolve(root, 'package.json'), JSON.stringify(rootPkgInfo, null, 2) + '\n')

  return targetVersion
}

/**
 * 生成 changelog 文件，同时将 changelog 及 package.json 更改提交
 */
async function generateChangelog(targetVersion) {
  step('\n生成 changelog')
  await execa('yarn', ['changelog'], { stdio: 'inherit' })

  // commit changes
  const { stdout } = await execa('git', ['diff'], { stdio: 'pipe' })
  if (stdout) {
    // 文件有变化，提交代码
    await execa('git', ['add', '-A'], { stdio: 'inherit' })
    await execa('git', ['commit', '-m', `chore(release): publish v${targetVersion}`], { stdio: 'inherit' })
  } else {
    console.log('No changes to commit.')
  }
}

/**
 * 打包构建
 */
async function buildModules() {
  step('\n打包构建')
  await execa('yarn', ['build'], { stdio: 'inherit' })
}

/**
 * 将包发布到 npm
 * @params {String} targetVersion 更新的版本号
 */
async function publishPkg(targetVersion) {
  step('\n发布 npm')
  const pkgName = rootPkgInfo.name
  try {
    // npm publish 发布
    await execa('npm', ['publish', root, '--access', 'public', '--registry', NPM_DEFAULT_REGISTRY], { stdio: 'pipe' })
    console.log(chalk.green(`Successfully published ${pkgName}@${targetVersion}`))
  } catch (e) {
    throw e
  }
}

/**
 * 打 tag 并推送到远程仓库
 */
async function gitTag(targetVersion) {
  step('\n打 tag')
  const suffixVersion = `v${targetVersion}`
  await execa('git', ['tag', suffixVersion], { stdio: 'inherit' })
  await execa('git', ['push', 'origin', `refs/tags/${suffixVersion}`], { stdio: 'inherit' })
  await execa('git', ['push'], { stdio: 'inherit' })
}

// 组合发布流程并执行
(async function main() {
  const targetVersion = await updateVersion()
  await generateChangelog(targetVersion)
  await buildModules()
  await publishPkg(targetVersion)
  await gitTag(targetVersion)
})().catch(err => {
  throw err
})