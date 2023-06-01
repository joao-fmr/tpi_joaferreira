allData.sort((l,o)=>new Date(l.valStoredDate)-new Date(o.valStoredDate));var t=[],a=[],r=[],n=[];for(var e in allData)t.push(allData[e].valStoredDate),a.push(allData[e].windStrength),r.push(allData[e].gustStrength),n.push(allData[e].averageStrength);var s=echarts.init(document.getElementById("graph")),d={title:{text:"Évolution de la force du vent depuis les dernières 96 heures"},legend:{data:["Force du vent","Force de rafale","Force moyenne"]},xAxis:{type:"category",data:t},yAxis:{type:"value"},tooltip:{trigger:"axis",axisPointer:{type:"cross"}},dataZoom:[{type:"inside"},{type:"slider"}],series:[{name:"Force du vent",data:a,type:"line"},{name:"Force de rafale",data:r,type:"line"},{name:"Force moyenne",data:n,type:"line"}]};s.setOption(d);
