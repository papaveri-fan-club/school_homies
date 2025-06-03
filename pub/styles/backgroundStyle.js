function generateBackgroundRows() {
    const backgroundText = document.getElementById('background-text');
    if (!backgroundText) return; // Esci se l'elemento non esiste
    const windowHeight = window.innerHeight;
    const rowHeight = 90; // Altezza di una riga + margine
    const rowsNeeded = Math.ceil(windowHeight / rowHeight) + 1; // +1 per sicurezza
    
    backgroundText.innerHTML = ''; // Pulisci le righe esistenti

    for (let i = 0; i < rowsNeeded; i++) {
        const row = document.createElement('div');
        row.className = 'text-row';
        
        // Calcola una durata dell'animazione leggermente diversa per ogni riga
        // per evitare un effetto troppo uniforme, usando l'indice i.
        // Alterna tra due set di durate base per le righe pari e dispari.
        let baseDuration = (i % 2 === 0) ? 60 : 70; // Durata base per righe pari/dispari
        let variation = (i * 5) % 20; // Variazione basata sull'indice
        const duration = baseDuration + variation;
        row.style.animationDuration = `${duration}s`;

        // Determina la direzione dell'animazione in base all'indice della riga (pari/dispari)
        // Se le regole :nth-child(odd/even) con animation-name sono in backgroundStyle.css,
        // questa riga potrebbe non essere necessaria o potrebbe sovrascriverle.
        // Per coerenza con lo script originale, la lascio.
        row.style.animationName = (i % 2 === 0) ? 'scrollLeft' : 'scrollRight';
        
        const screenWidth = window.innerWidth;
        const brickWidth = 300; // Larghezza approssimativa di un "brick" inclusi i margini
        const bricksNeeded = Math.ceil((screenWidth * 2) / brickWidth) + 2; // +2 per sicurezza ai bordi

        for (let j = 0; j < bricksNeeded; j++) {
            const brick = document.createElement('span');
            brick.className = 'brick';
            brick.textContent = 'SCHOOL HOMIES';
            const opacity = 0.15 + (Math.random() * 0.15); // Leggermente meno opaco
            brick.style.color = `rgba(255, 255, 255, ${opacity})`;
            const bgOpacity = 0.03 + (Math.random() * 0.07); // Leggermente meno opaco
            brick.style.backgroundColor = `rgba(255, 255, 255, ${bgOpacity})`;
            row.appendChild(brick);
        }
        backgroundText.appendChild(row);
    }
}

// Rigenera allo scroll e al resize
window.addEventListener('load', generateBackgroundRows);
window.addEventListener('resize', generateBackgroundRows);