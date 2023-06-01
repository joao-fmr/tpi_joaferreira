graphData.sort((o,d)=>new Date(o.valStoredDate)-new Date(d.valStoredDate));var t=[],a=[],r=[],n=[];for(var e in graphData){var s=new Date(graphData[e].valStoredDate),g=s.toLocaleDateString("fr-FR",{day:"numeric",month:"numeric",year:"numeric",hour:"numeric",minute:"numeric"});t.push(g),a.push(graphData[e].windStrength),r.push(graphData[e].gustStrength),n.push(graphData[e].averageStrength)}window.addEventListener("resize",function(){i.resize()});var i=echarts.init(document.getElementById("graph")),p={legend:{data:["Force du vent","Force de rafale","Force moyenne"],left:"center",orient:"vertical"},xAxis:{type:"category",data:t},yAxis:{type:"value"},grid:{top:"20%"},tooltip:{trigger:"axis",axisPointer:{type:"cross"}},dataZoom:[{type:"inside"},{type:"slider"}],series:[{name:"Force du vent",data:a,type:"line"},{name:"Force de rafale",data:r,type:"line"},{name:"Force moyenne",data:n,type:"line"}]};i.setOption(p);
