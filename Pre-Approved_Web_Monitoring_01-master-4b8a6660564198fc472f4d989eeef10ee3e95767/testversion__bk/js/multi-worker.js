self.addEventListener('message', function(e) {
    busyWork(e.data);
});

function busyWork(totalSeconds) {
    var elapsedSeconds = 0,
            nextSecond = Date.now();

    while (elapsedSeconds < totalSeconds) {
        nextSecond += 1000;
        while (Date.now() < nextSecond) {
            // churning
        }

        // send message back to UI thread to show progress
        self.postMessage(++elapsedSeconds);
    }
}