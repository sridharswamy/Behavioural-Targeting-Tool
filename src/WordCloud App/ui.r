
attach("Corpus.RData")
fluidPage(
  
  titlePanel("Word Cloud"),

  sidebarLayout(
      sidebarPanel(
      actionButton("update", "Change"),
      hr(),
      sliderInput("freq",
                  "Minimum Frequency:",
                  min = 1,  max = 50, value = 15),
      sliderInput("max",
                  "Maximum Number of Words:",
                  min = 1,  max = 300,  value = 100)
    ),
  mainPanel(
      plotOutput("plot")
    )
  )
)