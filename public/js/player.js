(() => {
    if (window.__PLAYER_BOOTED) return;
    window.__PLAYER_BOOTED = true;

    const audio = window.audioPlayer || document.getElementById('global-player');
    if (!audio) return;
    window.audioPlayer = audio;

    const titleEl = document.getElementById('player-title');
    const artistEl = document.getElementById('player-artist');
    const coverEl = document.getElementById('player-cover');
    const placeholderEl = document.getElementById('player-placeholder');
    const seekEl = document.getElementById('player-seek');
    const durationEl = document.getElementById('player-duration');
    const timeEl = document.getElementById('player-time');
    const volumeEl = document.getElementById('player-volume');
    const muteEl = document.getElementById('player-mute');
    const actionButtons = document.querySelectorAll('[data-player-action]');

    let queue = [];
    let currentIndex = 0;
    let status = 'paused';
    let lastSavedSecond = 0;

    const storage = {
        queue: 'cloud_player_queue',
        index: 'cloud_player_index',
        status: 'cloud_player_status',
        positions: 'cloud_player_positions',
    };

    const loadPositions = () => {
        try {
            return JSON.parse(localStorage.getItem(storage.positions) || '{}');
        } catch (_) {
            return {};
        }
    };

    const positions = loadPositions();

    const trackKey = (track) => track?.id || track?.src || 'unknown';

    const formatTime = (seconds) => {
        const value = Math.floor(seconds || 0);
        const mins = Math.floor(value / 60);
        const secs = value % 60;
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    };

    const persistState = () => {
        localStorage.setItem(storage.queue, JSON.stringify(queue));
        localStorage.setItem(storage.index, String(currentIndex));
        localStorage.setItem(storage.status, status);
        localStorage.setItem(storage.positions, JSON.stringify(positions));
    };

    const updateUI = (track) => {
        titleEl.textContent = track?.title || 'Nothing playing';
        artistEl.textContent = track?.artist || 'Select a song';

        if (track?.cover) {
            coverEl.src = track.cover;
            coverEl.classList.remove('hidden');
            placeholderEl.classList.add('hidden');
        } else {
            coverEl.src = '';
            coverEl.classList.add('hidden');
            placeholderEl.classList.remove('hidden');
        }

        const toggleBtn = document.querySelector('[data-player-action="toggle"]');
        if (toggleBtn) {
            toggleBtn.textContent = audio.paused ? 'Play' : 'Pause';
        }
    };

    const loadTrack = (track, options = {}) => {
        if (!track) return;

        const { startAt, autoplay = false, resume = true } = options;
        const savedTime = resume ? positions[trackKey(track)] || 0 : 0;
        const startTime = typeof startAt === 'number' ? startAt : savedTime;

        audio.src = track.src;
        audio.load();

        audio.onloadedmetadata = () => {
            audio.currentTime = Math.min(startTime, audio.duration || startTime);
            seekEl.max = audio.duration || 0;
            seekEl.value = audio.currentTime;
            durationEl.textContent = formatTime(audio.duration);
            timeEl.textContent = formatTime(audio.currentTime);

            if (autoplay) {
                audio.play().catch(() => {});
            }
        };

        updateUI(track);
        persistState();
    };

    const playAtIndex = (index) => {
        if (!queue.length) return;
        currentIndex = (index + queue.length) % queue.length;
        status = 'playing';
        loadTrack(queue[currentIndex], { autoplay: true, resume: true });
        persistState();
    };

    const trackFromElement = (el) => ({
        src: el.dataset.src,
        title: el.dataset.title,
        artist: el.dataset.artist,
        cover: el.dataset.cover,
        id: el.dataset.songId,
    });

    const buildQueueFromContainer = (container) => {
        const buttons = [...container.querySelectorAll('.js-play')];
        return buttons.map(trackFromElement);
    };

    const handlePlayClick = (button) => {
        const container = button.closest('[data-tracklist]');
        if (container) {
            queue = buildQueueFromContainer(container);
            currentIndex = [...container.querySelectorAll('.js-play')].indexOf(button);
        } else {
            queue = [trackFromElement(button)];
            currentIndex = 0;
        }

        status = 'playing';
        loadTrack(queue[currentIndex], { autoplay: true, resume: true });
    };

    const handleQueuePlayAll = (button) => {
        const target = button.dataset.target;
        const container = target
            ? document.querySelector(`[data-tracklist="${target}"]`)
            : null;
        if (!container) return;

        queue = buildQueueFromContainer(container);
        currentIndex = 0;
        status = 'playing';
        loadTrack(queue[currentIndex], { autoplay: true, resume: true });
    };

    document.addEventListener('click', (event) => {
        const playBtn = event.target.closest('.js-play');
        if (playBtn) {
            handlePlayClick(playBtn);
            return;
        }

        const queueBtn = event.target.closest('.js-queue');
        if (queueBtn) {
            handleQueuePlayAll(queueBtn);
            return;
        }
    });

    actionButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const action = btn.dataset.playerAction;
            if (action === 'toggle') {
                if (audio.paused) {
                    audio.play().catch(() => {});
                    status = 'playing';
                } else {
                    audio.pause();
                    status = 'paused';
                }
                updateUI(queue[currentIndex]);
                persistState();
            }

            if (action === 'next') {
                playAtIndex(currentIndex + 1);
            }

            if (action === 'prev') {
                playAtIndex(currentIndex - 1);
            }
        });
    });

    seekEl.addEventListener('input', (event) => {
        const value = Number(event.target.value);
        if (audio.duration) {
            audio.currentTime = value;
            timeEl.textContent = formatTime(value);
        }
    });

    seekEl.addEventListener('change', () => {
        positions[trackKey(queue[currentIndex] || {})] = audio.currentTime;
        persistState();
    });

    volumeEl.addEventListener('input', (event) => {
        audio.volume = Number(event.target.value);
        if (audio.volume === 0) {
            audio.muted = true;
        } else {
            audio.muted = false;
        }
    });

    muteEl.addEventListener('click', () => {
        audio.muted = !audio.muted;
        muteEl.textContent = audio.muted ? 'Unmute' : 'Mute';
    });

    audio.addEventListener('play', () => {
        status = 'playing';
        updateUI(queue[currentIndex]);
        persistState();
    });

    audio.addEventListener('pause', () => {
        status = 'paused';
        updateUI(queue[currentIndex]);
        persistState();
    });

    audio.addEventListener('timeupdate', () => {
        if (!audio.duration) return;
        seekEl.max = audio.duration;
        seekEl.value = audio.currentTime;
        timeEl.textContent = formatTime(audio.currentTime);
        durationEl.textContent = formatTime(audio.duration);

        const currentSecond = Math.floor(audio.currentTime);
        if (currentSecond !== lastSavedSecond) {
            positions[trackKey(queue[currentIndex] || {})] = audio.currentTime;
            lastSavedSecond = currentSecond;
            persistState();
        }
    });

    audio.addEventListener('seeking', () => {
        timeEl.textContent = formatTime(audio.currentTime);
    });

    audio.addEventListener('ended', () => {
        if (queue.length > 1) {
            playAtIndex(currentIndex + 1);
        } else {
            status = 'paused';
            persistState();
        }
    });

    const loadState = () => {
        try {
            const savedQueue = localStorage.getItem(storage.queue);
            queue = savedQueue ? JSON.parse(savedQueue) : [];
            currentIndex = Number(localStorage.getItem(storage.index)) || 0;
            status = localStorage.getItem(storage.status) || 'paused';

            if (queue[currentIndex]) {
                loadTrack(queue[currentIndex], {
                    autoplay: status === 'playing',
                    resume: true,
                });
            }
        } catch (_) {
            queue = [];
        }
    };

    window.Player = {
        play(track) {
            queue = [track];
            currentIndex = 0;
            status = 'playing';
            loadTrack(track, { autoplay: true, resume: true });
        },
        queue(tracks, startIndex = 0) {
            queue = tracks;
            playAtIndex(startIndex);
        },
        setSource(track, options = {}) {
            // Update source without resetting other UI bits
            loadTrack(track, { autoplay: options.autoplay ?? true, resume: options.resume ?? true, startAt: options.startAt });
        },
        seek(seconds) {
            if (!audio.duration) return;
            audio.currentTime = Math.min(Math.max(seconds, 0), audio.duration);
            timeEl.textContent = formatTime(audio.currentTime);
            positions[trackKey(queue[currentIndex] || {})] = audio.currentTime;
            persistState();
        },
    };

    document.addEventListener('turbo:load', () => {
        updateUI(queue[currentIndex]);
    });

    loadState();
})();
