allData.sort((a,t)=>new Date(a.valStoredDate)-new Date(t.valStoredDate));var r=[],n=[],i=[],o=[];for(var e in allData){let t=new Date(allData[e].valStoredDate).toLocaleDateString("fr-FR",{day:"numeric",month:"numeric",year:"numeric",hour:"numeric",minute:"numeric"});r.push(t),n.push(allData[e].windStrength),i.push(allData[e].gustStrength),o.push(allData[e].averageStrength)}window.addEventListener("resize",function(){l.resize()});var l=echarts.init(document.getElementById("graph")),d={legend:{data:["Force du vent","Force de rafale","Force moyenne"],left:"center",orient:"vertical"},xAxis:{type:"category",data:r},yAxis:{type:"value"},grid:{top:"20%"},tooltip:{trigger:"axis",axisPointer:{type:"cross"}},dataZoom:[{type:"inside"},{type:"slider"}],series:[{name:"Force du vent",data:n,type:"line"},{name:"Force de rafale",data:i,type:"line"},{name:"Force moyenne",data:o,type:"line"}]};l.setOption(d);