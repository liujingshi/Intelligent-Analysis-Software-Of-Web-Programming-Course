
from bs4 import BeautifulSoup as BS
from sys import argv
from json import dumps

def readFile(fileName):
    fileObj = None
    try:
        fileObj = open(fileName, encoding="utf-8")
    except:
        try:
            fileObj = open(fileName, encoding="gbk")
        except:
            try:
                fileObj = open(fileName, encoding="gb2312")
            except:
                pass
    return fileObj

def notIsFrame(name):
    notUseStatic = ['min.js', 'min.css', 'jquery', 'Jquery', 'jQuery', 'JQUERY', 'layui', 'LAYUI', 'bootstrap', 'Bootstrap', 'BootStrap', 'BOOTSTRAP']
    for s in notUseStatic:
        if s in name:
            return False
    return True

eg = ""
if len(argv) > 1:
    eg = argv[1]
else:
    eg = input("Please input eg:")

if eg == "":
    exit()

rootPath = "pages/"
rootFileName = "/index.html"
fileName = rootPath + eg + rootFileName

fileObj = readFile(fileName)

if fileName is None:
    exit()

res = {
    "js": "",
    "css": "",
    "html": "",
    "all": "",
    "static": {
        "js": [],
        "css": []
    }
}

fileText = fileObj.read()
bsObj = BS(fileText, "html.parser")

scripts = bsObj.find_all("script")
for script in scripts:
    if script.text.replace(" ", "").replace("\n", "").replace("\r", "") == "":
        try:
            jsSrc = script['src']
            if notIsFrame(jsSrc):
                jsFileName = rootPath + eg + "/" + jsSrc
                jsFileObj = readFile(jsFileName)
                if not jsFileObj is None:
                    jsFileText = jsFileObj.read()
                    res['static']['js'].append({
                        "name": jsSrc,
                        "text": jsFileText
                    })
        except:
            pass
    else:
        res['js'] += "\n" + script.text

links = bsObj.find_all("link", {"rel": "stylesheet"})
for link in links:
    try:
        cssHref = link['href']
        if notIsFrame(cssHref):
            cssFileName = rootPath + eg + "/" + cssHref
            cssFileObj = readFile(cssFileName)
            if not cssFileObj is None:
                cssFileText = cssFileObj.read()
                res['static']['css'].append({
                    "name": cssHref,
                    "text": cssFileText
                })
    except:
        pass

styles = bsObj.find_all("style")
for style in styles:
    res['css'] += "\n" + style.text

res['all'] = str(bsObj)

[s.extract() for s in bsObj(['script', 'link', 'style'])] 
res['html'] = str(bsObj)

resJson = dumps(res)

print(resJson)
