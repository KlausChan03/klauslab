
/**
 * 获取图片的EXIF Orientation值
 * @param {File} file - 图片文件
 * @returns {Promise<number>} Orientation值 (1-8)
 */
const getOrientation = (file) => {
    return new Promise((resolve) => {
        EXIF.getData(file, function () {
            const orient = EXIF.getTag(this, 'Orientation') || 1
            resolve(orient)
        })
    })
}

/**
 * 将DataURL转换为File对象
 * @param {string} dataurl - DataURL字符串
 * @param {string} filename - 文件名
 * @returns {File} File对象
 */
const dataURLtoFile = (dataurl, filename) => {
    const arr = dataurl.split(',')
    const mime = arr[0].match(/:(.*?);/)[1]
    const bstr = atob(arr[1])
    let n = bstr.length
    let u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, { type: mime });
}

/**
 * 根据EXIF Orientation值修正图片方向
 * 支持所有8种orientation值：
 * 1: 正常（0°）
 * 2: 水平翻转
 * 3: 旋转180°
 * 4: 垂直翻转
 * 5: 顺时针90°+水平翻转
 * 6: 顺时针90°（iOS常见）
 * 7: 逆时针90°+水平翻转
 * 8: 逆时针90°
 * 
 * @param {Image} image - 图片对象
 * @param {number} orientation - EXIF Orientation值
 * @returns {string} 修正后的DataURL
 */
const fixImageOrientation = (image, orientation) => {
    const canvas = document.createElement('canvas')
    const ctx = canvas.getContext('2d')
    
    // 默认尺寸
    let width = image.width
    let height = image.height
    
    // 根据orientation调整canvas尺寸和变换
    switch (orientation) {
        case 2:
            // 水平翻转
            canvas.width = width
            canvas.height = height
            ctx.translate(width, 0)
            ctx.scale(-1, 1)
            break
        case 3:
            // 旋转180°
            canvas.width = width
            canvas.height = height
            ctx.translate(width, height)
            ctx.rotate(Math.PI)
            break
        case 4:
            // 垂直翻转
            canvas.width = width
            canvas.height = height
            ctx.translate(0, height)
            ctx.scale(1, -1)
            break
        case 5:
            // 顺时针90°+水平翻转
            canvas.width = height
            canvas.height = width
            ctx.rotate(0.5 * Math.PI)
            ctx.scale(1, -1)
            break
        case 6:
            // 顺时针90°（iOS竖拍常见）
            canvas.width = height
            canvas.height = width
            ctx.rotate(0.5 * Math.PI)
            ctx.translate(0, -height)
            break
        case 7:
            // 逆时针90°+水平翻转
            canvas.width = height
            canvas.height = width
            ctx.rotate(-0.5 * Math.PI)
            ctx.translate(-width, height)
            ctx.scale(1, -1)
            break
        case 8:
            // 逆时针90°
            canvas.width = height
            canvas.height = width
            ctx.rotate(-0.5 * Math.PI)
            ctx.translate(-width, 0)
            break
        default:
            // 1: 正常，不需要变换
            canvas.width = width
            canvas.height = height
            break
    }
    
    // 绘制图片
    ctx.drawImage(image, 0, 0)
    
    // 返回修正后的图片DataURL，保持原格式质量
    return canvas.toDataURL("image/jpeg", 0.95)
}

/**
 * 修正图片方向（兼容旧代码）
 * @deprecated 使用 fixImageOrientation 代替
 */
const rotateImage = (image, width, height) => {
    return fixImageOrientation(image, 6)
}
