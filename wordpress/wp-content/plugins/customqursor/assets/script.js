document.addEventListener('DOMContentLoaded', function() {
    const cursor = document.querySelector('#cursor');
    const templates = adminHoverTemplate;
    let mouseX = window.innerWidth / 2, mouseY = window.innerHeight / 2;
    let cursorX = window.innerWidth / 2, cursorY = window.innerHeight / 2;
    const delay = 0.05;


    if ( !cursor ) {
        return;
    }

    // Met à jour la couleur du pointeur
    cursor.querySelector('.point').style.backgroundColor = templates.defaultColor;

    // Mettre à jour la position de la souris
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
    });

    function animate() {
        cursorX += (mouseX - cursorX) * delay;
        cursorY += (mouseY - cursorY) * delay;

        cursor.style.transform = `translate(${cursorX}px, ${cursorY}px)`;
        requestAnimationFrame(animate);
    }

    animate();

    // Changer le curseur sur le survol
    for (let index = 1; index < 4; index++) {
        for (const [key, value] of Object.entries(templates)) {
            if (key !== 'default' && key !== 'defaultColor') {
                if (!!value['class'] && !!value['template']) {
                    const hoverclass = value['class'];
                    const hoverEl = document.querySelectorAll(`.${hoverclass}`);
            
                    hoverEl.forEach(e => {
                        e.addEventListener("mouseenter", () => {
                            cursor.innerHTML = value['template'];
                            e.style.cursor = 'none';
                        });
                    });
            
                    hoverEl.forEach(e => {
                        e.addEventListener("mouseleave", () => {
                            cursor.innerHTML = templates.default;
                            e.style.cursor = 'auto';
                        });
                    });
                }
            }
          }
    }
});