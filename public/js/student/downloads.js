// Function to show the downloads page content
function showDownloadsPage() {
    document.getElementById("download-content").style.display = "block";
}

// Function to load the study materials based on selected grade and subject
function loadMaterials() {
    const grade = document.getElementById("grade").value;
    const subject = document.getElementById("subject").value;
    const materialList = document.getElementById("materialList");

    // Clear previous list
    materialList.innerHTML = "";

    // Sample study materials data with file links
    const studyMaterials = {
        "grade6": {
            "math": [
                { name: "Basic Algebra and Equations", file: "grade6_math_addition.pdf" },
                { name: "Quadratic Equations and Functions", file: "grade6_equation.pdf" },
                { name: "Number Systems and Operations", file: "grade6_math_numbersystem.pdf" },
                { name: "Fractions, Decimals, and Percentages", file: "grade6_math_fractions.pdf" } 
            ],
            "science": [
                { name: "Cell Biology and Microscopy", file: "grade6_science_chemistry.pdf" },
                { name: "States of Matter and Changes", file: "grade6_science_biology.pdf" },
                { name: "Basics of Force and Motion", file: "grade6_science_chemistry.pdf" },
                { name: "Acids, Bases, and pH Levels", file: "grade6_science_biology.pdf" }
            ],
            "history": [
                { name: "Ancient Civilizations: Mesopotamia, Egypt", file: "grade6_history_civilizations.pdf" },
                { name: "Introduction to History", file: "grade6_history_intro.pdf" },
                { name: "Greek and Roman Empires", file: "grade6_history_civilizations.pdf" },
                { name: "Early Asian Empires", file: "grade6_history_intro.pdf" }
        
            ],
            "ict": [
                { name: "Number system", file: "Number system.pdf" },
                { name: "Basics of Internet and Email", file: "grade6_equation.pdf" },
                { name: "Understanding Coding Basics", file: "grade6_math_numbersystem.pdf" },
                { name: "Introduction to Databases", file: "grade6_math_fractions.pdf" }
 
            ],
            "geography": [
                { name: "Climate Change and Sustainability", file: "grade6_science_chemistry.pdf" },
                { name: "Industries and Trade", file: "grade6_science_biology.pdf" },
                { name: "River and Ocean Geography", file: "grade6_science_chemistry.pdf" },
                { name: "Forests and Wildlife Conservation", file: "grade6_science_biology.pdf" }
            ],
            "english": [
                { name: "Narrative Writing", file: "grade6_history_civilizations.pdf" },
                { name: "Vocabulary Building", file: "grade6_history_intro.pdf" },
                { name: "Creative Writing: Essays and Short Stories", file: "grade6_history_civilizations.pdf" },
                { name: "Advanced Grammar", file: "grade6_history_intro.pdf" }       
            ]
        },
        "grade7": {
            "math": [
                { name: "Linear Graphs and Coordinates", file: "grade7_math_subtraction.pdf" },
                { name: "Geometry Basics", file: "grade7_math_geometry.pdf" },
                { name: "Ratios and Proportions", file: "grade7_math_subtraction.pdf" },
                { name: "Algebraic Expressions and Equations", file: "grade7_math_geometry.pdf" },
                { name: "Perimeter, Area, and Volume", file: "grade7_math_subtraction.pdf" },
                { name: "Probability Basics", file: "grade7_math_geometry.pdf" }
           
            ],
            "science": [
                { name: "Human Digestive System", file: "grade7_science_plants.pdf" },
                { name: "Photosynthesis and Plant Nutrition", file: "grade7_science_physics.pdf" },
                { name: "Periodic Table and Element Properties", file: "grade7_science_plants.pdf" },
                { name: "Introduction to Organic Chemistry", file: "grade7_science_physics.pdf" }
            ],
            "history": [
                { name: "World History", file: "grade7_history_world.pdf" },
                { name: "Medieval Times", file: "grade7_history_medieval.pdf" },
                { name: "Renaissance and Reformation", file: "grade7_history_world.pdf" },
                { name: "Age of Exploration", file: "grade7_history_medieval.pdf" }
           
            ],
            "ict": [
                { name: "Introduction to Computers", file: "grade6_math_addition.pdf" },
                { name: "Basics of Internet and Email", file: "grade6_equation.pdf" },
                { name: "Understanding Coding Basics", file: "grade6_math_numbersystem.pdf" },
                { name: "Introduction to Databases", file: "grade6_math_fractions.pdf" }
 
            ],
            "geography": [
                { name: "Climate Change and Sustainability", file: "grade6_science_chemistry.pdf" },
                { name: "Industries and Trade", file: "grade6_science_biology.pdf" },
                { name: "River and Ocean Geography", file: "grade6_science_chemistry.pdf" },
                { name: "Forests and Wildlife Conservation", file: "grade6_science_biology.pdf" }
            ],
            "english": [
                { name: "Narrative Writing", file: "grade6_history_civilizations.pdf" },
                { name: "Vocabulary Building", file: "grade6_history_intro.pdf" },
                { name: "Creative Writing: Essays and Short Stories", file: "grade6_history_civilizations.pdf" },
                { name: "Advanced Grammar", file: "grade6_history_intro.pdf" }
        
            ]
        },
        "grade8": {
            "math": [
                { name: "Fractions", file: "grade8_math_fractions.pdf" },
                { name: "Introduction to Probability", file: "grade8_math_algebra.pdf" },
                { name: "Statistics: Mean, Median, Mode", file: "grade8_math_fractions.pdf" },
                { name: "Exponents and Powers", file: "grade8_math_algebra.pdf" }
           
            ],
            "science": [
                { name: "Electricity and Magnetism", file: "grade8_science_electricity.pdf" },
                { name: "Advanced Biology", file: "grade8_science_biology_advanced.pdf" },
                { name: "Ecosystems and Environmental Conservation", file: "grade8_science_electricity.pdf" },
                { name: "Balancing Chemical Equations", file: "grade8_science_biology_advanced.pdf" }
            ],
            "history": [
                { name: "Modern History", file: "grade8_history_modern.pdf" },
                { name: "World Wars", file: "grade8_history_worldwars.pdf" },
                { name: "Industrial Revolution", file: "grade8_history_modern.pdf" },
                { name: "19th Century World Events", file: "grade8_history_worldwars.pdf" }
           
            ],
            "ict": [
                { name: "Introduction to Computers", file: "grade6_math_addition.pdf" },
                { name: "Basics of Internet and Email", file: "grade6_equation.pdf" },
                { name: "Understanding Coding Basics", file: "grade6_math_numbersystem.pdf" },
                { name: "Introduction to Databases", file: "grade6_math_fractions.pdf" }
 
            ],
            "geography": [
                { name: "Climate Change and Sustainability", file: "grade6_science_chemistry.pdf" },
                { name: "Industries and Trade", file: "grade6_science_biology.pdf" },
                { name: "River and Ocean Geography", file: "grade6_science_chemistry.pdf" },
                { name: "Forests and Wildlife Conservation", file: "grade6_science_biology.pdf" }
            ],
            "english": [
                { name: "Narrative Writing", file: "grade6_history_civilizations.pdf" },
                { name: "Vocabulary Building", file: "grade6_history_intro.pdf" },
                { name: "Creative Writing: Essays and Short Stories", file: "grade6_history_civilizations.pdf" },
                { name: "Advanced Grammar", file: "grade6_history_intro.pdf" }
        
            ]
        },
        "grade9": {
            "math": [
                { name: "Quadratic Equations", file: "grade9_math_addition.pdf" },
                { name: "Coordinate Geometry", file: "grade9_equation.pdf" },
                { name: "Trigonometry Basics", file: "grade9_math_numbersystem.pdf" },
                { name: "Statistics and Probability", file: "grade9_math_fractions.pdf" }
 
            ],
            "science": [
                { name: "Genetics and Heredity", file: "grade9_science_chemistry.pdf" },
                { name: "Acids, Bases, and Salts", file: "grade9_science_biology.pdf" },
                { name: "Basics of Force and Motion", file: "grade9_science_chemistry.pdf" },
                { name: "Newton's Laws of Motion", file: "grade9_science_biology.pdf" }
            ],
            "history": [
                { name: "Ancient Civilizations: Mesopotamia, Egypt", file: "grade9_history_civilizations.pdf" },
                { name: "Introduction to History", file: "grade9_history_intro.pdf" },
                { name: "Greek and Roman Empires", file: "grade9_history_civilizations.pdf" },
                { name: "Early Asian Empires", file: "grade9_history_intro.pdf" }
        
            ],
            "ict": [
                { name: "Introduction to Computers", file: "grade6_math_addition.pdf" },
                { name: "Basics of Internet and Email", file: "grade6_equation.pdf" },
                { name: "Understanding Coding Basics", file: "grade6_math_numbersystem.pdf" },
                { name: "Introduction to Databases", file: "grade6_math_fractions.pdf" }
 
            ],
            "geography": [
                { name: "Climate Change and Sustainability", file: "grade6_science_chemistry.pdf" },
                { name: "Industries and Trade", file: "grade6_science_biology.pdf" },
                { name: "River and Ocean Geography", file: "grade6_science_chemistry.pdf" },
                { name: "Forests and Wildlife Conservation", file: "grade6_science_biology.pdf" }
            ],
            "english": [
                { name: "Narrative Writing", file: "grade6_history_civilizations.pdf" },
                { name: "Vocabulary Building", file: "grade6_history_intro.pdf" },
                { name: "Creative Writing: Essays and Short Stories", file: "grade6_history_civilizations.pdf" },
                { name: "Advanced Grammar", file: "grade6_history_intro.pdf" }
        
            ]
        },
        "grade10": {
            "math": [
                { name: "Linear Graphs and Coordinates", file: "grade7_math_subtraction.pdf" },
                { name: "Geometry Basics", file: "grade7_math_geometry.pdf" },
                { name: "Ratios and Proportions", file: "grade7_math_subtraction.pdf" },
                { name: "Algebraic Expressions and Equations", file: "grade7_math_geometry.pdf" },
                { name: "Perimeter, Area, and Volume", file: "grade7_math_subtraction.pdf" },
                { name: "Probability Basics", file: "grade7_math_geometry.pdf" }
           
            ],
            "science": [
                { name: "Human Digestive System", file: "grade7_science_plants.pdf" },
                { name: "Photosynthesis and Plant Nutrition", file: "grade7_science_physics.pdf" },
                { name: "Periodic Table and Element Properties", file: "grade7_science_plants.pdf" },
                { name: "Introduction to Organic Chemistry", file: "grade7_science_physics.pdf" }
            ],
            "history": [
                { name: "World History", file: "grade7_history_world.pdf" },
                { name: "Medieval Times", file: "grade7_history_medieval.pdf" },
                { name: "Renaissance and Reformation", file: "grade7_history_world.pdf" },
                { name: "Age of Exploration", file: "grade7_history_medieval.pdf" }
           
            ],
            "ict": [
                { name: "Introduction to Computers", file: "grade6_math_addition.pdf" },
                { name: "Basics of Internet and Email", file: "grade6_equation.pdf" },
                { name: "Understanding Coding Basics", file: "grade6_math_numbersystem.pdf" },
                { name: "Introduction to Databases", file: "grade6_math_fractions.pdf" }
 
            ],
            "geography": [
                { name: "Climate Change and Sustainability", file: "grade6_science_chemistry.pdf" },
                { name: "Industries and Trade", file: "grade6_science_biology.pdf" },
                { name: "River and Ocean Geography", file: "grade6_science_chemistry.pdf" },
                { name: "Forests and Wildlife Conservation", file: "grade6_science_biology.pdf" }
            ],
            "english": [
                { name: "Narrative Writing", file: "grade6_history_civilizations.pdf" },
                { name: "Vocabulary Building", file: "grade6_history_intro.pdf" },
                { name: "Creative Writing: Essays and Short Stories", file: "grade6_history_civilizations.pdf" },
                { name: "Advanced Grammar", file: "grade6_history_intro.pdf" }
        
            ]
        },
        "grade11": {
            "math": [
                { name: "Fractions", file: "grade8_math_fractions.pdf" },
                { name: "Introduction to Probability", file: "grade8_math_algebra.pdf" },
                { name: "Statistics: Mean, Median, Mode", file: "grade8_math_fractions.pdf" },
                { name: "Exponents and Powers", file: "grade8_math_algebra.pdf" }
           
            ],
            "science": [
                { name: "Electricity and Magnetism", file: "grade8_science_electricity.pdf" },
                { name: "Advanced Biology", file: "grade8_science_biology_advanced.pdf" },
                { name: "Ecosystems and Environmental Conservation", file: "grade8_science_electricity.pdf" },
                { name: "Balancing Chemical Equations", file: "grade8_science_biology_advanced.pdf" }
            ],
            "history": [
                { name: "Modern History", file: "grade8_history_modern.pdf" },
                { name: "World Wars", file: "grade8_history_worldwars.pdf" },
                { name: "Industrial Revolution", file: "grade8_history_modern.pdf" },
                { name: "19th Century World Events", file: "grade8_history_worldwars.pdf" }
           
            ],
            "ict": [
                { name: "Introduction to Computers", file: "grade6_math_addition.pdf" },
                { name: "Basics of Internet and Email", file: "grade6_equation.pdf" },
                { name: "Understanding Coding Basics", file: "grade6_math_numbersystem.pdf" },
                { name: "Introduction to Databases", file: "grade6_math_fractions.pdf" }
 
            ],
            "geography": [
                { name: "Climate Change and Sustainability", file: "grade6_science_chemistry.pdf" },
                { name: "Industries and Trade", file: "grade6_science_biology.pdf" },
                { name: "River and Ocean Geography", file: "grade6_science_chemistry.pdf" },
                { name: "Forests and Wildlife Conservation", file: "grade6_science_biology.pdf" }
            ],
            "english": [
                { name: "Narrative Writing", file: "grade6_history_civilizations.pdf" },
                { name: "Vocabulary Building", file: "grade6_history_intro.pdf" },
                { name: "Creative Writing: Essays and Short Stories", file: "grade6_history_civilizations.pdf" },
                { name: "Advanced Grammar", file: "grade6_history_intro.pdf" }
        
            ]
        }
    };

    // Get the materials for the selected grade and subject
    const materials = studyMaterials[grade][subject];

    // Display the materials in the list with download buttons
    materials.forEach(material => {
        const li = document.createElement("li");
        li.innerHTML = `${material.name} <a href="downloads/${material.file} <?php echo $row['file_path']; ?>" target="_blank" class="download-btn" download>Download<?php echo $row['title']; ?></a>`;
        materialList.appendChild(li);
    });
}