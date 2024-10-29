const songs = [
    { 
        artist: "Dua Lipa", 
        title: "Don't Start Now", 
        src: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3',
        image: 'https://upload.wikimedia.org/wikipedia/zh/6/63/Dua_Lipa_-_Don%27t_Start_Now.png' 
    },
    { 
        artist: "Ed Sheeran", 
        title: "Shape of You", 
        src: 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3',
        image: 'https://upload.wikimedia.org/wikipedia/en/8/8e/Ed_Sheeran_-_Shape_of_You.png' 
    },
    // 添加其他歌曲...
];

const audioPlayer = document.getElementById('audio-player');

function displayPlaylist() {
    const tbody = document.querySelector('#playlist tbody');
    songs.forEach((song, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="image-container"><img src="${song.image}" alt="${song.artist}"></td>
            <td class="artist">${song.artist}</td>
            <td class="title">${song.title}</td>
        `;
        tr.onclick = () => playSong(index);
        tbody.appendChild(tr);
    });
}

function playSong(index) {
    audioPlayer.src = songs[index].src;
    audioPlayer.play();
}

displayPlaylist();
