function downloadFile(projectId, fileId) {
    fetch("/api/downloadFile.php?projects_id=" + projectId + "&files_id=" + fileId)
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileId;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        });
}

function deleteFile(projectId, fileId) {
    console.log(projectId, fileId);
    console.log("/api/deleteFile.php?projects_id=" + projectId + "&files_id=" + fileId);
    fetch(`/api/deleteFile.php?projects_id=${projectId}&files_id=${fileId}`)
        .then(response => response.json())
        .then(res => {
            if (res.code != 200) {
                alert(res.data.error);
                return;
            }
            $(`#${fileId}`).remove();
        });

}
